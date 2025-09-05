<?php

namespace App\Jobs;

use App\Models\SmsLog;
use App\Services\Client\SMS\SMSService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Queue\Queueable;

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
        $result = (new SMSService())->send($this->data['phone'], $this->data['message']);

        SmsLog::create([
            'merchant_id' => $this->data['merchant_id'],
            'session_id'  => $this->data['session_id'],
            'phone'       => $this->data['phone'],
            'message'     => $this->data['message'],
            'status'      => $result['status'],
            'url'         => $this->data['url'],
        ]);
    }
}
