<?php

namespace App\Services\Client;

use App\Models\CheckoutSession;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class CheckoutService
{
    public function getSessionData(string $sessionId): ?CheckoutSession
    {
        return CheckoutSession::where('session_id_enc', $sessionId)
            ->where('expires_at', '>', now())
            ->first();
    }

    public function expireSession(CheckoutSession $session): void
    {
        $session->expires_at = now();
        $session->save();
    }

    public function getRedirectUrl(string $sessionId): string
    {
        $session = $this->createSession($sessionId);
        $originalUrl = route('client.index', ['sessionId' => $session['token']]);
        $urlWithPort = str_replace(
            'https://vrectest.embafinans.az',
            'https://vrectest.embafinans.az:7443',
            $originalUrl
        );
        return $urlWithPort;
    }

    protected function getPrefix(): string
    {
        return App::environment('production') ? 'cs_custom' : 'cs_test';
    }

    public function getSessionId(): string
    {
        return Str::ulid();
    }

    /**
     * Create a temporary checkout session token for uploads/redirects.
     * Returns array: ['token' => string, 'expires_at' => CarbonInterface]
     */
    public function createSession(string $sessionId): array
    {
        $ttl = 60;
        $prefix = $this->getPrefix();
        $rand = bin2hex(random_bytes(20));
        $encryptedId = $prefix . '_' . $rand . '_' . $sessionId;

        $record = CheckoutSession::create([
            'session_id' => $sessionId,
            'session_id_enc' => $encryptedId,
            'expires_at' => now()->addMinutes($ttl),
        ]);

        return [
            'token' => $record->session_id_enc,
            'expires_at' => $record->expires_at,
        ];
    }
}
