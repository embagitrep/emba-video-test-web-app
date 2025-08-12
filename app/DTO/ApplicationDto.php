<?php

namespace App\DTO;

class ApplicationDto extends BaseDto
{
    public string $order_id;
    public string $pin;
    public string $serial_number;
    public string $phone;
    public string $payment_method;
    public int $installment;
    public float $amount;
    public string $status;
    public string $currency;
    public array $phones;
    public ?string $conference_id;
    public ?string $conference_url;

    public function __construct(
        string $order_id,
        string $pin, 
        string $serial_number,
        string $phone, 
        string $payment_method,
        int $installment, 
        float $amount, 
        ?string $conference_id = null,
        ?string $conference_url = null,
        string $status = 'pending', 
        string $currency = 'AZN',
        array $phones = []
    ) {
        $this->order_id = $order_id;
        $this->pin = $pin;
        $this->serial_number = $serial_number;
        $this->phone = $phone;
        $this->payment_method = $payment_method;
        $this->installment = $installment;
        $this->amount = $amount;
        $this->conference_id = $conference_id;
        $this->conference_url = $conference_url;
        $this->status = $status;
        $this->currency = $currency;
        $this->phones = $phones;
    }
}
