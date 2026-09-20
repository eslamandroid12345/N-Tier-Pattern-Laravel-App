<?php

namespace App\Architecture\Services\Classes\Auth;

use App\Helpers\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthWebService extends AuthService
{

    public function login(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getByMobileNumber($data['phone']);
            if($user->active == 0){
                return $this->apiHttpResponder->sendError(message: 'User activation close,Please contact admin support.',code: Http::FORBIDDEN);

            }
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return $this->apiHttpResponder->sendValidationError('User data un correct!');
            }
            $otp = $this->otpService->generateOTP($user->id);
            if (app()->environment('production')) {
                $otp = 'Your sign-in OTP is: ' . $otp;
                //Add service use to send sms for user
            }
            DB::commit();
            return $this->apiHttpResponder->sendSuccess([
                'user' => [
                    'phone' => $data['phone'],
                ]
            ],message: 'Code send successfully,Please check your sms.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiHttpResponder->sendError(message: 'Login user failed!',logs: [
                'login/login_mobile_error',//file name
                'Failed to login with mobile (Error!).',//message log
                $e//exception
            ]);
        }
    }
}
