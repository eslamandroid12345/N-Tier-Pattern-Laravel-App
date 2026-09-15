<?php

namespace App\Architecture\Services\Classes\Auth;

use App\Enum\DeviceType;
use App\Events\User\UserLogin;
use App\Helpers\Http;
use App\Http\Resources\User\UserDeviceResource;
use App\Http\Resources\User\UserResource;

class AuthWebService extends AuthService
{
    public function login(array $data)
    {
        try {
            if (!auth()->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return $this->apiHttpResponder->sendValidationError(message: 'Email or password not correct!');
            }

            $user = auth()->user();
            $device = null;
            if (!empty($data['token'])) {
                $device = $this->userDeviceRepository->updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'device' => DeviceType::WEBSITE->value,
                        'token' => $data['token'],
                    ],
                    []
                );
            }

            UserLogin::dispatch($user);//Event Fire When User Login In System.
            return $this->apiHttpResponder->sendSuccess([
                'token' => $user->createToken('MyAuthApp')->plainTextToken,
                'user' => new UserResource($user),
                'device' => $device ? new UserDeviceResource($device) : null,

            ], message: 'User Login Successfully.');

        } catch (\Exception $e) {

            return $this->apiHttpResponder->sendError(message: 'Login user failed!',logs: [
                "login/login_website_error",//file name
                "Failed to login with website (Error!).",//message log
                $e//exception
            ]);
        }
    }

}
