<?php

namespace App\Services;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class VonageService
{
    protected $client;

    public function __construct()
    {
        $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $this->client = new Client($basic);
    }

    public function sendSMS($to, $from, $text)
    {
        $response = $this->client->sms()->send(
            new SMS($to, $from, $text)
        );

        return $response->current()->getStatus() === 0;
    }
}
