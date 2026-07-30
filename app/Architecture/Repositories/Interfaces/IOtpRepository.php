<?php

namespace App\Architecture\Repositories\Interfaces;

interface IOtpRepository extends IAbstractRepository
{
    public function clearOtp(int $userId);
    public function validateOtp(int $userId, int $code);


}
