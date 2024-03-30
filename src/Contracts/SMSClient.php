<?php

namespace AbdullahFaqeir\OTP\Contracts;

use AbdullahFaqeir\OTP\Notifications\Messages\MessagePayload;

interface SMSClient
{
    public function sendMessage(MessagePayload $payload): mixed;
}
