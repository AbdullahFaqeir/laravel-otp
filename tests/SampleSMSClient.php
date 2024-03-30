<?php

namespace AbdullahFaqeir\OTP\Tests;

use AbdullahFaqeir\OTP\Contracts\SMSClient;
use AbdullahFaqeir\OTP\Notifications\Messages\MessagePayload;

class SampleSMSClient implements SMSClient
{
    public function sendMessage(MessagePayload $payload): mixed
    {
        return null;
        // dump($payload->to(),$payload->content());
    }
}
