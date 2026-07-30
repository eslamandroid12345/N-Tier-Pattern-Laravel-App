<?php

namespace App\Architecture\Services\Classes\Auth;

use App\Helpers\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthMobileService extends AuthService
{
    public function login(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getByMobileNumber($data['mobile']);
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return $this->apiHttpResponder->sendError(__('end-user/auth.unauthorized'),  Http::UNPROCESSABLE_ENTITY);
            }
            $otp = $this->otpService->generateOTP($user->id);
            if (app()->environment('production')) {
                $otp = 'Your sign-in OTP is: ' . $otp;
                //Add service use to send sms for user
            }
            DB::commit();
            return $this->apiHttpResponder->sendSuccess([
                'message' => __('end-user/auth.otp_send'),
                'data' => [
                    'mobile' => $data['mobile'],
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiHttpResponder->sendError(__('end-user/auth.error_login'));
        }
    }

}
