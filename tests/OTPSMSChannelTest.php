<?php

namespace AbdullahFaqeir\OTP\Tests;

use AbdullahFaqeir\OTP\Contracts\SMSClient;
use AbdullahFaqeir\OTP\Notifications\Channels\OTPSMSChannel;
use AbdullahFaqeir\OTP\Notifications\Messages\MessagePayload;
use AbdullahFaqeir\OTP\Notifications\Messages\OTPMessage;
use AbdullahFaqeir\OTP\Notifications\OTPNotification;
use AbdullahFaqeir\OTP\Tests\Models\OTPNotifiableUser;
use Mockery as m;

class OTPSMSChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_token_successfully(): void
    {
        $notifiable = m::mock(OTPNotifiableUser::class);
        $notification = m::mock(OTPNotification::class);
        $messagePayload = m::mock(MessagePayload::class);
        $OTPMessage = m::mock(OTPMessage::class);
        $SMSClient = m::mock(SMSClient::class);

        $OTPMessage->shouldReceive('getPayload')->andReturn($messagePayload);
        $notifiable->shouldReceive('routeNotificationFor')->with('otp', $notification)->andReturnTrue();
        $notification->shouldReceive('toSMS')->with($notifiable)->andReturn($OTPMessage);

        $SMSClient->shouldReceive('sendMessage')->with($messagePayload)->andReturn(true);

        $OTPSMSChannel = new OTPSMSChannel($SMSClient);

        $this->assertTrue($OTPSMSChannel->send($notifiable, $notification));
    }

    /** @test */
    public function it_does_not_work_when_there_is_no_otp_route_notification(): void
    {
        $notifiable = m::mock(OTPNotifiableUser::class);
        $notification = m::mock(OTPNotification::class);
        $SMSClient = m::mock(SMSClient::class);

        $notifiable->shouldReceive('routeNotificationFor')
                   ->with('otp', $notification)
                   ->andReturnFalse();

        $OTPSMSChannel = new OTPSMSChannel($SMSClient);

        $this->assertNull($OTPSMSChannel->send($notifiable, $notification));
    }
}
