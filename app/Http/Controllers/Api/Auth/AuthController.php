<?php

namespace App\Http\Controllers\Api\Auth;

use App\Architecture\Services\Interfaces\IAuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ResendCodeRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserLogoutRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Http\Requests\Auth\UserVerifyRequest;

class AuthController extends Controller
{
    public function __construct(
        private readonly IAuthService $authService
    ) {}

    public function register(UserRegisterRequest $request)
    {
        return $this->authService->register((array)$request->toDTO());
    }

    public function login(UserLoginRequest $request)
    {
        return $this->authService->login((array)$request->toDTO());
    }

    public function verify(UserVerifyRequest $request)
    {
        return $this->authService->verify((array) $request->toDTO());
    }

    public function resendCode(ResendCodeRequest $request)
    {
        return $this->authService->resendCode((array) $request->toDTO());
    }

    public function profile()
    {
        return $this->authService->profile();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->authService->updateProfile((array) $request->toDTO());
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->authService->changePassword((array) $request->toDTO());
    }
    public function logout(UserLogoutRequest $request)
    {
        return $this->authService->logout((array) $request->toDTO());
    }

}
