<?php

namespace App\Architecture\Repositories\Classes;


use App\Architecture\Repositories\Interfaces\IOtpRepository;
use Illuminate\Support\Carbon;

class OtpRepository extends AbstractRepository implements IOtpRepository
{

    public function clearOtp(int $userId): void
    {
        $query = $this->prepareQuery()->where('user_id',$userId);
        $query->delete();
    }

    public function validateOtp(int $userId, int $code): bool
    {
        $query = $this->prepareQuery()
            ->where('user_id', $userId)
            ->where('expired_at', '>', Carbon::now());

        $otpRecord = $query->latest('id')->first();

        if ($otpRecord && $otpRecord->code === $code) {
            return true;
        }
        return false;
    }
}
