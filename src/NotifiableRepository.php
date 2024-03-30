<?php

namespace AbdullahFaqeir\OTP;

use AbdullahFaqeir\OTP\Contracts\NotifiableRepositoryInterface;
use AbdullahFaqeir\OTP\Contracts\OTPNotifiable;

class NotifiableRepository implements NotifiableRepositoryInterface
{
    protected string $mobileColumn;

    public function __construct(protected OTPNotifiable $model)
    {
        $this->mobileColumn = config('otp.mobile_column');
    }

    public function findOrCreateByMobile(string $mobile): OTPNotifiable
    {
        return $this->model->firstOrCreate([$this->mobileColumn => $mobile]);
    }

    public function findByMobile(string $mobile): ?OTPNotifiable
    {
        return $this->model->where([$this->mobileColumn => $mobile])->first(['id', $this->mobileColumn]);
    }

    public function getModel(): OTPNotifiable
    {
        return $this->model;
    }
}
