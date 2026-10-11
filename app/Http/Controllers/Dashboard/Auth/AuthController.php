<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Architecture\Services\Interfaces\IAuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserLogoutRequest;

class AuthController extends Controller
{
    public function __construct(
        private readonly IAuthService $authService
    ) {}

    public function view()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard.home');
        }

        return view('admin.auth.login');
    }

    public function home()
    {
        return view('admin.dashboard.home');
    }
    public function login(UserLoginRequest $request)
    {
        return $this->authService->login((array)$request->toDTO());
    }

    public function logout(UserLogoutRequest $request)
    {
        return $this->authService->logout((array) $request->toDTO());
    }

}
