<?php

namespace AbdullahFaqeir\OTP\Notifications\Channels;

use AbdullahFaqeir\OTP\Contracts\OTPNotifiable;
use AbdullahFaqeir\OTP\Contracts\SMSClient;
use AbdullahFaqeir\OTP\Notifications\Messages\OTPMessage;
use Illuminate\Notifications\Notification;

class OTPSMSChannel
{
    public function __construct(protected SMSClient $SMSClient)
    {
    }

    public function send(OTPNotifiable $notifiable, Notification $notification): mixed
    {
        if (! $notifiable->routeNotificationFor('otp', $notification)) {
            return null;
        }

        /** @var OTPMessage $message */
        $message = $notification->toSMS($notifiable);

        return $this->SMSClient->sendMessage($message->getPayload());
    }
}
