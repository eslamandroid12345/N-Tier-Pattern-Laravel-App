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
                return $this->apiHttpResponder->sendError(message: __('auth.unauthorized'), code: Http::UNPROCESSABLE_ENTITY);
            }

            $user = auth()->user();
            $device = null;
            if (!empty($data['device']) && !empty($data['token'])) {
                $device = $this->userDeviceRepository->updateOrCreate(
                    [
                        'client_id' => $user->id,
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

        }catch (\Exception $exception){
            return $this->apiHttpResponder->sendError(message: 'Login Failed!');
        }
    }

}
