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
            $user = $this->userRepository->getByMobileNumber($data['phone']);
            if($user->active == 0){
                return $this->apiHttpResponder->sendError(message: __('user/auth/login.account_inactive'),code: Http::FORBIDDEN);

            }
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return $this->apiHttpResponder->sendValidationError(__('user/auth/login.invalid_credentials'));
            }
            $otp = $this->otpService->generateOTP($user->id);
            if (app()->environment('production')) {
                $otp = 'Your sign-in OTP is: ' . $otp;
                /*
                |--------------------------------------------------------------------------
                | ADD SERVICE USED HERE TO SEND SMS
                |--------------------------------------------------------------------------
                */
            }
            DB::commit();
            return $this->apiHttpResponder->sendSuccess([
                'user' => [
                    'phone' => $data['phone'],
                ]
            ],message:  __('user/auth/login.code_sent'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiHttpResponder->sendError(message: 'Login user failed!',logs: [
                'login/login_mobile_error',//file name
                __('user/auth/login.failed_login'),//message log
                $e//exception
            ]);
        }
    }

}
