<?php

namespace App\Http\Controllers\Api\User;

use App\Architecture\Services\Interfaces\IUserService;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public function __construct(
        private readonly IUserService $userService,
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:users,users-view', only: ['index']),
        ];
    }
    public function index()
    {
        return $this->userService->index();
    }

    public function list()
    {
        return $this->userService->list();
    }

}
