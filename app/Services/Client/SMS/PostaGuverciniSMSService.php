<?php

namespace App\Services\Client\SMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PostaGuverciniSMSService
{
    protected Client $httpClient;
    protected string $apiUrl;
    protected string $publicKey;
    protected string $privateKey;
    protected string $sender;

    public function __construct()
    {
        $this->httpClient = new Client;
        $this->apiUrl     = config('sms.PG_API_URL');
        $this->publicKey  = config('sms.PG_PUBLIC_KEY');
        $this->privateKey = config('sms.PG_PRIVATE_KEY');
        $this->sender     = config('sms.PG_SENDER');
    }

    public function send(string $phone, string $message): array
    {
        $phone = '994' . $phone;

        $url = rtrim($this->apiUrl, '/') . '/gateway/api/sms/v1/message/send'
            . '?publicKey=' . urlencode($this->publicKey);

        try {
            $response = $this->httpClient->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->privateKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'Text'    => $message,
                    'Purpose' => 'INF',
                    'Options' => [
                        'Originator' => $this->sender,
                        'Encoding'   => 'UNICODE',
                    ],
                    'Receivers' => [
                        ['Receiver' => $phone],
                    ],
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            if (($body['Status'] ?? null) === 200) {
                return ['success' => 1, 'status' => 'sent'];
            }

            return [
                'success' => 0,
                'status'  => 'failed',
                'message' => $body['Description'] ?? 'Unknown error',
            ];
        } catch (RequestException $e) {
            return [
                'success' => 0,
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ];
        }
    }
}
