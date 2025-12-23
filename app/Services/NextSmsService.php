<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class NextSmsService
{
    protected $client;
    protected $apiKey;
    protected $senderId;
    protected $baseUrl = 'https://messaging-service.co.tz/api/sms/v1/text/single';

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('NEXTSMS_API_KEY');
        $this->senderId = env('NEXTSMS_SENDER_ID');
    }

    public function sendSms($recipients, $message, $reference = null)
    {
        try {
            $to = is_array($recipients) ? $recipients : [$recipients];

            $payload = [
                'from' => $this->senderId,
                'to' => $to,
                'text' => $message,
            ];

            if ($reference) {
                $payload['reference'] = $reference;
            }

            Log::info('NextSMS Request', [
                'url' => $this->baseUrl,
                'headers' => ['Authorization' => 'Basic ' . $this->apiKey],
                'payload' => $payload,
            ]);

            $response = $this->client->post($this->baseUrl, [
                'headers' => [
                    'Authorization' => 'Basic ' . $this->apiKey,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            Log::info('NextSMS Response', $responseData);

            if (isset($responseData['messages']) && !empty($responseData['messages'])) {
                foreach ($responseData['messages'] as $msg) {
                    if ($msg['status']['groupName'] !== 'PENDING') {
                        return [
                            'error' => true,
                            'message' => 'Some messages failed: ' . $msg['status']['description'],
                        ];
                    }
                }
                return $responseData;
            }

            return $responseData;
        } catch (RequestException $e) {
            $errorResponse = [
                'error' => true,
                'message' => $e->getMessage(),
            ];
            Log::error('NextSMS Error', $errorResponse);
            return $errorResponse;
        }
    }
}