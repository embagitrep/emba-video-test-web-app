<?php

namespace App\Services\Api;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Client\CheckoutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function store(array $data): array
    {

        try {
            $sessionId = (new CheckoutService())->getSessionId();
            DB::transaction(function () use ($data, $sessionId) {
                $data['status'] = 'pending';
                $data['session_id'] = $sessionId;
                      // Upsert by merchant_id + app_id to reuse the same record
                      $order = Order::where('merchant_id', $data['merchant_id'])
                      ->where('app_id', $data['app_id'])
                      ->first();
  
                  if ($order) {
                      $order->fill($data);
                      $order->save();
                  } else {
                      Order::create($data);
                  }
               
            });

            return [
                'success' => 1,
                'message' => 'Order created successfully',
                'sessionId' => $sessionId,
                'lang' => $data['lang']??'az'
            ];
        }catch (\Exception $e) {
            Log::error('OrderService.store failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return [
                'success' => 0,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getBySession(string $sessionId): ?Order
    {
        return Order::with(['merchant'])->where('session_id', $sessionId)->first();
    }
}