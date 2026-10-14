<?php

namespace App\Http\Controllers\Api\User;

use App\Architecture\Services\Interfaces\IUserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserDestroyRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
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
            new Middleware('permission:users,users-create', only: ['store']),
            new Middleware('permission:users,users-update', only: ['update']),
            new Middleware('permission:users,users-delete', only: ['delete']),
        ];
    }

    /**
     * Endpoint: GET /api/mobile/users
     * Endpoint: GET /api/website/users
     */
    public function index()
    {
        return $this->userService->index();
    }

    /**
     * Endpoint: GET /api/mobile/users-list
     * Endpoint: GET /api/website/users-list
     */
    public function list()
    {
        return $this->userService->list();
    }

    /**
     * Endpoint: POST /api/mobile/users
     * Endpoint: POST /api/website/users
     */
    public function store(UserStoreRequest $request)
    {
        return $this->userService->store((array)$request->toDTO());
    }

    /**
     * Endpoint: PUT /api/mobile/users
     * Endpoint: PUT /api/website/users
     */
    public function update(UserUpdateRequest $request)
    {
        return $this->userService->update((array)$request->toDTO(),$request->getUuid());
    }

    /**
     * Endpoint: DELETE /api/mobile/users
     * Endpoint: DELETE /api/website/users
     */
    public function destroy(UserDestroyRequest $request)
    {
        return $this->userService->destroy($request->getUuid());
    }

}
