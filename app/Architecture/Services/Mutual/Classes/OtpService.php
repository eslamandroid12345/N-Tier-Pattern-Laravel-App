<?php

namespace App\Architecture\Services\Mutual\Classes;

use App\Architecture\Repositories\Interfaces\IOtpRepository;
use App\Architecture\Responder\IApiHttpResponder;
use App\Architecture\Services\Mutual\Interfaces\IOtpService;
use Illuminate\Support\Carbon;

class OtpService implements IOtpService
{
    public function __construct(
        protected readonly IApiHttpResponder $apiHttpResponder,
        protected readonly IOtpRepository    $otpRepository,
    )
    {
    }

    public function generateOTP(int $userId, int $expirationDate = 20): int
    {

        $otp = app()->environment('production') ? mt_rand(1000,9999) : 5555 ;

        $this->otpRepository->create([
            'user_id' => $userId,
            'code' => $otp,
            'expired_at' => Carbon::now()->addMinutes($expirationDate),
        ]);
        return $otp;
    }
    public function clearOTP(int $userId)
    {
        return $this->otpRepository->clearOtp($userId);
    }

    public function regenerateOTP(int $userId,int $expirationDate = 20): int
    {
        $this->clearOTP($userId);
        return $this->generateOTP($userId,$expirationDate);
    }

    public function validateOTP(int $userId, int $code)
    {
        return $this->otpRepository->validateOtp($userId, $code);
    }

}
