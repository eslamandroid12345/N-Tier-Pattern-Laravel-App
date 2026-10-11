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
       return $this->getResponder->handle(resource: UsersResource::class, repository: $this->userRepository, message: 'Users Get Successfully.', exception_message: 'Users List Get Error!',
           method: 'filter',
           is_paginate: true
       );
   }

    public function list()
    {
        return $this->getResponder->handle(resource: UsersListResource::class, repository: $this->userRepository, message: 'Users Get Successfully.', exception_message: 'Users List Get Error!',
            method: 'getData',
            parameters: [
                'conditions' => ['active' => 1],
                'columns' => ['id','uuid','first_name','last_name','email'],
                'isPagination' => true
            ],
            is_paginate: true
        );
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

}
