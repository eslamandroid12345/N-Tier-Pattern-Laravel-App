<?php

namespace App\Architecture\Services\Classes\User;

use App\Architecture\Repositories\Interfaces\IUserRepository;
use App\Architecture\Responder\IApiHttpResponder;
use App\Architecture\Responder\IGetResponder;
use App\Architecture\Services\Interfaces\IUserService;
use App\Architecture\Services\Mutual\Interfaces\IFileManagerService;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UsersListResource;
use App\Http\Resources\User\UsersResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class UserService implements IUserService
{
   public function __construct(
       private readonly IUserRepository     $userRepository,
       private readonly IGetResponder       $getResponder,
       private readonly IFileManagerService $fileManagerService,
       private readonly IApiHttpResponder   $apiHttpResponder
   )
   {
   }


    public function index()
    {
        return $this->getResponder->handle(
            resource: UsersResource::class,
            repository: $this->userRepository,
            message: __('user/actions/user.users_get_success'),
            exception_message: __('user/actions/user.users_get_failed'),
            method: 'filter',
            is_paginate: true
        );
    }

    public function list()
    {
        $cacheKey = getCacheSetting(key: 'users_list_version', slug: 'users', action: 'list');

        return Cache::remember($cacheKey, getCacheTtl(), function () {
            return $this->getResponder->handle(
                resource: UsersListResource::class,
                repository: $this->userRepository,
                message: __('user/actions/user.users_get_success'),
                exception_message: __('user/actions/user.users_get_failed'),
                method: 'getData',
                parameters: [
                    'conditions'   => ['active' => 1],
                    'columns'      => ['id', 'uuid', 'first_name', 'last_name', 'email'],
                    'isPagination' => true
                ],
                is_paginate: true
            );
        });
    }


    public function store(array $data){

        DB::beginTransaction();
        try {
            if (!empty($data['image'])) {
                $data['image'] = $this->fileManagerService->handle('image','users/images');
            }

            $user = $this->userRepository->create($data);

            DB::commit();
            return $this->apiHttpResponder->sendSuccess([
                'user' => new UserResource($user)
            ],message: 'User Created Successfully.',
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiHttpResponder->sendError(
                message: 'User Create Failed!',
                logs: [
                    'user/user_created_error',
                    'User Created (Error!).',
                    $e
                ]
            );
        }
    }

    public function update(array $data,string $uuid)
    {
        try {
            $user = $this->userRepository->getData(conditions:['uuid' => $uuid],isFirst: true);
            if (!empty($data['image'])) {
                $data['image'] = $this->fileManagerService->handle('image', 'users/images', $user->getRawOriginal('image'));
            } else {
                unset($data['image']);
            }
            $user = $this->userRepository->update(['uuid' => $uuid], $data);

            return $this->apiHttpResponder->sendSuccess([
                'user' => new UserResource($user),
            ], message: __('user/actions/user.user_update_success'));
        } catch (\Exception $e) {
            return $this->apiHttpResponder->sendError(
                message: __('user/actions/user.user_update_failed'),
                logs: [
                    'user/user_updated_error',
                    'Failed To Update User (Error!).',
                    $e
                ]
            );
        }
    }

    public function destroy(string $uuid)
    {
        try {
            $user = $this->userRepository->getData(conditions:['uuid' => $uuid],isFirst: true);
            $this->userRepository->destroy($user->id);

            return $this->apiHttpResponder->sendSuccess(message: __('user/actions/user.user_delete_success'));
        } catch (\Exception $e) {

            return $this->apiHttpResponder->sendError(
                message: __('user/actions/user.user_delete_failed'),
                logs: [
                    'user/user_delete_error',
                    'Failed To Delete User (Error!).',
                    $e
                ]
            );
        }
    }
}
