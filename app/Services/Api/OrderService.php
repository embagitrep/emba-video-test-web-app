<?php

namespace App\Services\Api;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Client\CheckoutService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function store(array $data): array
    {

        try {
            $sessionId = (new CheckoutService())->getSessionId();
            DB::transaction(function () use ($data, $sessionId) {
                $data['status'] = 'pending';
                $data['session_id'] = $sessionId;
                Order::create($data);
            });

            return [
                'success' => 1,
                'message' => 'Order created successfully',
                'sessionId' => $sessionId,
                'lang' => $data['lang']??'az'
            ];
        }catch (\Exception $e) {
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