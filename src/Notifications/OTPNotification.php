<?php

declare(strict_types=1);

namespace AbdullahFaqeir\OTP\Notifications;

use Closure;
use AbdullahFaqeir\OTP\Notifications\Messages\OTPMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class OTPNotification extends Notification
{
    public static ?Closure $toMailCallback = null;

    public static ?Closure $toSMSCallback = null;

    public function __construct(private readonly string $token, private readonly array $channels)
    {
    }

    public static function toMailUsing(Closure $callback): void
    {
        static::$toMailCallback = $callback;
    }

    public static function toSMSUsing(Closure $callback): void
    {
        static::$toSMSCallback = $callback;
    }

    public function via($notifiable): array
    {
        return $this->channels;
    }

    public function toSMS($notifiable)
    {
        if (static::$toSMSCallback) {
            return call_user_func(static::$toSMSCallback, $notifiable, $this->token);
        }

        return $this->buildSMSMessage($notifiable);
    }

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        return $this->buildMailMessage();
    }

    protected function buildSMSMessage($notifiable): OTPMessage
    {
        return (new OTPMessage())
            ->to($notifiable->getMobileForOTPNotification())
            ->content(Lang::get('OTP::otp.otp_token', ['token' => $this->token]));
    }

    protected function buildMailMessage(): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('OTP::otp.otp_subject'))
            ->line(Lang::get('OTP::otp.otp_token', ['token' => $this->token]));
    }
}
