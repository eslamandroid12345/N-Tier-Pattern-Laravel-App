<?php

namespace App\Http\Controllers\Api\Auth;

use App\Architecture\Services\Interfaces\IAuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\VerifyRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly IAuthService $authService
    ) {}

    public function login(LoginAuthRequest $request)
    {
        return $this->authService->login((array)$request->toDTO());
    }

    public function verify(VerifyRequest $request)
    {
        return $this->authService->verify((array) $request->toDTO());
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        return $this->authService->logout((array) $request->toDTO());
    }

}
