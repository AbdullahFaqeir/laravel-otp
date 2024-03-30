<?php

namespace Fouladgar\OTP\Notifications\Channels;

use Fouladgar\OTP\Contracts\OTPNotifiable;
use Fouladgar\OTP\Contracts\SMSClient;
use Fouladgar\OTP\Notifications\Messages\OTPMessage;
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
