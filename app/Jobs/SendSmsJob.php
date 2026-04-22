<?php

namespace App\Jobs;

use App\Models\SmsLog;
use App\Services\Client\SMS\SMSService;
use App\Services\Client\SMS\PostaGuverciniSMSService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public array $data;

    /**
     * Maximum number of tries (only once).
     */
    public $tries = 1;

    /**
     * Timeout in seconds.
     */
    public $timeout = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Unique job identifier (avoid duplicate SMS).
     */
    public function uniqueId(): string
    {
        return $this->data['session_id'] . '_' . $this->data['phone'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $provider = config('sms.PROVIDER', 'lsim');
        $phone    = $this->data['phone'];
        $message  = $this->data['message'];

        if ($provider === 'postaGuvercini') {
            $result = (new PostaGuverciniSMSService())->send($phone, $message);
        } else {
            $result = (new SMSService())->send($phone, $message);

            // Fallback to Posta Güvercini if L.Sim fails and PG is configured
            if (($result['success'] ?? 0) === 0 && config('sms.PG_API_URL')) {
                Log::warning('L.Sim SMS failed, trying Posta Güvercini fallback', ['phone' => $phone]);
                $result = (new PostaGuverciniSMSService())->send($phone, $message);
            }
        }

        SmsLog::create([
            'merchant_id' => $this->data['merchant_id'],
            'session_id'  => $this->data['session_id'],
            'phone'       => $this->data['phone'],
            'message'     => $this->data['message'],
            'status'      => $result['status'] ?? 'failed',
            'url'         => $this->data['url'],
        ]);
    }
}
