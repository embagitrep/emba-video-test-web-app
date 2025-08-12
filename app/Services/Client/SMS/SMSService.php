<?php

namespace App\Services\Client\SMS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class SMSService
{
    protected Client $httpClient;

    protected string $apiUrl;

    protected string $apiKey;

    protected string $apiUsername;

    protected string $sender;

    public function __construct()
    {
        $this->httpClient = new Client;
        $this->apiUrl = config('sms.API_URL');
        $this->apiKey = config('sms.API_KEY');
        $this->apiUsername = config('sms.API_USERNAME');
        $this->sender = config('sms.SENDER');
    }

    public function send($phone, $message)
    {
        $phone = "994".$phone;
        $passwordHashed = md5($this->apiKey);
        $key = md5($passwordHashed.$this->apiUsername.$message.$phone.$this->sender);
        $queryParams = [
            'login' => $this->apiUsername,
            'key' => $key,
            'msisdn' => $phone,
            'sender' => $this->sender,
            'text' => $message,
            'unicode' => 0,
        ];

        $url = $this->apiUrl.'?'.http_build_query($queryParams);
        $output = [];

        try {
            $response = $this->httpClient->get($url);
            $response = json_decode($response->getBody()->getContents(),1);

            if (!$response['errorCode']){
                $output['success'] = 1;
                $output['status'] = 'sent';
            }else{
                $output['success'] = 0;
                $output['status'] = 'failed';
            }

            return $output;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $output['success'] = 0;
                $output['status'] = 'failed';
                $output['message'] = $response->getReasonPhrase();

                return $output;
            } else {
                return 'Error: '.$e->getMessage();
            }
        }
    }
}
