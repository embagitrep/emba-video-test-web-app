<?php

namespace App\Console\Commands;

use App\Enums\VideoStatusEnum;
use App\Jobs\OrderStatusJob;
use App\Models\Order;
use Illuminate\Console\Command;

class OrderStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:order-status-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Order::where('status',VideoStatusEnum::RECORDED)->orderBy('created_at', 'desc')->chunk(100, function ($orders) {
           OrderStatusJob::dispatch($orders);
        });
    }
}
