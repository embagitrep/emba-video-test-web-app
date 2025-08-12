<?php

namespace App\Jobs;

use App\Enums\VideoStatusEnum;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class OrderStatusJob implements ShouldQueue
{
    use Queueable;

    public $orders;

    /**
     * Create a new job instance.
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->orders as $order) {
            if (!empty($order->webhook_url)) {
                try {
                    $client = new Client();
                    $client->request('POST', $order->webhook_url, [
                        'json' => [
                            'app_id'    => $order->app_id,
                            'video_url' => env('APP_URL') . '/videos/' . $order->app_id,
                            'status'    => VideoStatusEnum::OK->value,
                        ],
                    ]);

                    $order->status = VideoStatusEnum::SENT;
                    $order->save();
                } catch (\Throwable $e) {
                    Log::error("Webhook failed for Order {$order->app_id}: " . $e->getMessage());
                }
            }
        }
    }
}
