<?php

namespace App\Architecture\Services\Mutual\Interfaces;

interface IOtpService
{
    public function generateOTP(int $userId, int $expirationDate = 20);
    public function clearOTP(int $userId);
    public function regenerateOTP(int $userId,int $expirationDate = 20);
    public function validateOTP(int $userId, int $code);
}
