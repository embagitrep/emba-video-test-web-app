<?php

namespace App\Jobs;

use App\Models\SmsLog;
use App\Services\Client\SMS\SMSService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSmsJob implements ShouldQueue
{
    use Queueable;

    public array $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $result = (new SMSService())->send($this->data['phone'], $this->data['message']);

        SmsLog::create([
            'merchant_id' => $this->data['merchant_id'],
            'session_id' => $this->data['session_id'],
            'phone' => $this->data['phone'],
            'message' => $this->data['message'],
            'status' => $result['status'],
            'url' => $this->data['url'],
        ]);
    }
}
