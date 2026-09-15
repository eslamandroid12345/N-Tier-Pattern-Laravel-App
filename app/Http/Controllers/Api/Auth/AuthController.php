<?php

namespace App\Http\Controllers\Api\Auth;

use App\Architecture\Services\Interfaces\IAuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginAuthRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly IAuthService $authService
    ) {}

    public function login(LoginAuthRequest $request): JsonResponse
    {
        return $this->authService->login($request->safe()->toArray());
    }


}
