<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class MobizonService
{
    public $token;
    public $domain;
    public $client;

    public function __construct()
    {
        $this->token = config('mobizon.token');
        $this->domain = config('mobizon.domain');
        $this->client = new Client([
            'base_uri' => $this->domain,
        ]);
    }

    // public function getList()
    // {
    //     $response = $this->client->post('/service/message/list', [
    //         'query' => [
    //             'apiKey' => $this->token
    //         ]
    //     ]);

    //     return json_decode($response->getBody()->getContents(), true);
    // }

    public function sendMessage($recipient, $text)
    {
        try {
            $response = $this->client->post('/service/message/sendsmsmessage', [
                'query' => [
                    'apiKey' => $this->token,
                    'recipient' => $recipient,
                    'text' => $text,
                ]
            ]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}