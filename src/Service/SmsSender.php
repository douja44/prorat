<?php

namespace App\Service;

use Twilio\Rest\Client;

class SmsSender
{
    private $twilioSid;
    private $twilioToken;
    private $twilioNumber;

    public function __construct(string $twilioSid, string $twilioToken, string $twilioNumber)
    {
        $this->twilioSid = $twilioSid;
        $this->twilioToken = $twilioToken;
        $this->twilioNumber = $twilioNumber;
    }

    public function sendSms(string $to, string $message): void
    {
        $client = new Client($this->twilioSid, $this->twilioToken);
        $client->messages->create(
            $to,
            [
                'from' => $this->twilioNumber,
                'body' => $message,
            ]
        );
    }
}
