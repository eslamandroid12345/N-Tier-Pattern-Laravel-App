<?php

namespace App\Architecture\Services\Classes\Auth;

use App\Architecture\Repositories\Interfaces\IUserDeviceRepository;
use App\Architecture\Repositories\Interfaces\IUserRepository;
use App\Architecture\Responder\IApiHttpResponder;
use App\Architecture\Services\Interfaces\IAuthService;
use App\Architecture\Services\Mutual\Interfaces\IFileManagerService;
use App\Architecture\Services\Mutual\Interfaces\IOtpService;
use App\Events\User\UserLogin;
use App\Http\Resources\User\UserDeviceResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

abstract class AuthService implements IAuthService
{
    public function __construct(
        protected readonly IApiHttpResponder     $apiHttpResponder,
        protected readonly IUserRepository       $userRepository,
        protected readonly IOtpService           $otpService,
        protected readonly IUserDeviceRepository $userDeviceRepository,
        protected readonly IFileManagerService   $fileManagerService,
    )
    {
    }

    //Verify login
    public function verify(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getByMobileNumber($data['phone']);
            if (!$this->otpService->validateOTP($user->id, $data['code'])) {//Check if OTP found for this user
                return $this->apiHttpResponder->sendValidationError(message: 'OTP for this user not exists!');
            }
            $this->otpService->clearOTP($user->id);
            $device = null;
            if (!empty($data['device']) && !empty($data['token'])) {//Register token with device type for user auth
                $device =  $this->userDeviceRepository->updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'device'    => $data['device'],
                        'token'    => $data['token'],
                    ],
                    []
                );
            }
            UserLogin::dispatch($user);//Event Fire When User Login In System.
            $this->userRepository->update(['id' => $user->id],['verified' => true]);
            DB::commit();
            return $this->apiHttpResponder->sendSuccess([
                'token' => $user->createToken('MyAuthApp')->plainTextToken,
                'device' => $device ? new UserDeviceResource($device) : null,
                'user' => new UserResource($user),

            ],message: 'User login successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiHttpResponder->sendError(
                message: 'OTP verify error!',
                logs: [
                    'login/login_verify_error',
                    'OTP Verify (Error!).',
                    $e
                ]
            );
        }
    }

    public function register(array $data)
    {
        DB::beginTransaction();
        try {
            if (!empty($data['image'])) {
                $data['image'] = $this->fileManagerService->handle('image','users/images');
            }
            $user = $this->userRepository->create($data);
            $otp = $this->otpService->generateOTP($user->id);
            if (app()->environment('production')) {
                //Add service use to send sms for user
            }
            DB::commit();
            return $this->apiHttpResponder->sendSuccess([
                'phone' => $data['phone']
            ],message: 'Code send successfully,Please check your sms.'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiHttpResponder->sendError(
                message: 'User Register Failed!',
                logs: [
                    'register/user_register_error',
                    'User Register (Error!).',
                    $e
                ]
            );
        }
    }

    public function resendCode(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->getByMobileNumber($data['phone']);
            $newCode = $this->otpService->regenerateOTP($user->id);
            if (app()->environment('production')) {
                //Add service use to send sms for user
            }
            DB::commit();
            return $this->apiHttpResponder->sendSuccess(message: 'Code Resend Successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiHttpResponder->sendError(
                message: 'Failed Generate New Code!',
                logs: [
                    'login/login_verify_error',
                    'Failed Generate New Code (Error!).',
                    $e
                ]
            );
        }
    }

    public function profile()
    {
        try {
            $user = auth()->user();
            $user->load(['role']);
            return $this->apiHttpResponder->sendSuccess([
                'user'  => new UserResource($user),
            ],message: 'Profile Data Get Successfully.');
        }catch (\Exception $e) {
            return $this->apiHttpResponder->sendError(
                message: 'Failed To Load Profile Data!',
                logs: [
                    'login/login_verify_error',
                    'Failed To Load Profile Data (Error!).',
                    $e
                ]
            );
        }

    }

    public function changePassword(array $data)
    {
        try {
            $user = auth()->user();
            if (!Hash::check($data['old_password'],$user->password)) {
                return $this->apiHttpResponder->sendValidationError(message: 'Old password not correct.');
            }
            if (Hash::check($data['new_password'], $user->password)) {
                return $this->apiHttpResponder->sendValidationError(message: 'The new password is the same old password!');
            }
            $this->userRepository->update(['id' => $user->id], ['password' => $data['new_password']]);

            return $this->apiHttpResponder->sendSuccess(message: 'Password updated successfully.');
        } catch (\Exception $e) {
            return $this->apiHttpResponder->sendError(
                message: 'Password Not Updated!',
                logs: [
                    'login/login_verify_error',
                    'Password Not Updated (Error!).',
                    $e
                ]
            );
        }
    }

    public function updateProfile(array $data)
    {
        try {
            $user = auth()->user();
            if (!empty($data['image'])) {
                $data['image'] = $this->fileManagerService->handle('image','users/images', $user->getRawOriginal('image'));
            }else {
                unset($data['image']);
            }
            $user = $this->userRepository->update(['id' => auth()->id()], $data);
            return $this->apiHttpResponder->sendSuccess([
                    'user' => new UserResource($user),
            ],message: 'Profile Data Update Successfully.');
        } catch (\Exception $e) {
            return $this->apiHttpResponder->sendError(
                message: 'Failed To Update Profile!',
                logs: [
                    'login/login_verify_error',
                    'Failed To Update Profile (Error!).',
                    $e
                ]
            );
        }
    }

    public function logout(array $data): JsonResponse
    {
        DB::beginTransaction();
        try {

            if(!empty($data['device'])) {
                $this->userRepository->destroy($data['device']);
            }
            auth()->user()->tokens()->delete();

            DB::commit();
            return $this->apiHttpResponder->sendSuccess(message: 'User logout successfully.');
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->apiHttpResponder->sendError(
                message: 'Failed to logout!',
                logs: [
                    'login/logout_error',
                    'User Logout (Error!).',
                    $e
                ]
            );
        }
    }
}
