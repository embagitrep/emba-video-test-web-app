<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Order\OrderStoreRequest;
use App\Jobs\SendSmsJob;
use App\Services\Api\OrderService;
use App\Services\Client\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct(protected readonly OrderService $service, protected readonly CheckoutService $checkoutService) {}

    public function store(OrderStoreRequest $request)
    {
        $data = $request->validated();
        $data['merchant_id'] = $request->merchantUser->id;
        $result = $this->service->store($data);
        $output = [];
        if ($result['success']) {
            $statusCode = 200;
            $output['success'] = 1;
            $output['message'] = $result['message'];
            $output['redirect_url'] = $this->checkoutService->getRedirectUrl($result['sessionId']);
            // Provide token and an upload API for mobile apps
            $session = $this->checkoutService->createSession($result['sessionId']);
            $output['token'] = $session['token'];
            $output['expires_at'] = $session['expires_at'];
            $output['upload_url'] = url('/api/upload/video');

            // Log decision inputs for SMS dispatch
            $wallet = $request->boolean('wallet');
            Log::info('API Order store: evaluating SMS dispatch', [
                'wallet' => $wallet,
                'merchant_id' => $data['merchant_id'],
                'session_id' => $result['sessionId'],
                'phone' => $data['phone'] ?? null,
                'redirect_url' => $output['redirect_url'] ?? null,
            ]);

            // Conditionally send SMS only when wallet flag is not true
            if (! $wallet) {
                try {
                    SendSmsJob::dispatch([
                        'merchant_id' => $data['merchant_id'],
                        'session_id' => $result['sessionId'],
                        'phone' => $data['phone'],
                        'message' => getTranslation('Please visit the {url} for video recording', ['url' => $output['redirect_url']], $data['lang']??'az'),
                        'url' => $output['redirect_url'],
                    ]);
                    Log::info('API Order store: SendSmsJob dispatched', [
                        'merchant_id' => $data['merchant_id'],
                        'session_id' => $result['sessionId'],
                        'phone' => $data['phone'],
                    ]);
                } catch (\Throwable $e) {
                    Log::error('API Order store: SendSmsJob dispatch failed', [
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ]);
                }
            } else {
                Log::info('API Order store: SMS skipped due to wallet flag', [
                    'wallet' => $wallet,
                ]);
            }
        }else{
            $statusCode = 400;
            $output['success'] = 0;
            $output['message'] = $result['message'];
        }


        return response()->json($output,$statusCode);
    }
}
