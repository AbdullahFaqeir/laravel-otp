<?php

namespace AbdullahFaqeir\OTP\Tests\Models;

use AbdullahFaqeir\OTP\Concerns\HasOTPNotify;
use AbdullahFaqeir\OTP\Contracts\OTPNotifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OTPNotifiableUser extends Model implements OTPNotifiable
{
    use Notifiable;
    use HasOTPNotify;
    use HasFactory;

    public $timestamps = false;

    protected $table = 'users';
}
