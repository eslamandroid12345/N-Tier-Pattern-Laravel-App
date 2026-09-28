<?php

namespace App\Architecture\Services\Classes\User;

use App\Architecture\Repositories\Interfaces\IUserRepository;
use App\Architecture\Responder\IGetResponder;
use App\Architecture\Services\Interfaces\IUserService;
use App\Http\Resources\User\UsersListResource;
use App\Http\Resources\User\UsersResource;

abstract class UserService implements IUserService
{
   public function __construct(
       private readonly IUserRepository $userRepository,
       private readonly IGetResponder $getResponder
   )
   {
   }

   public function index()
   {
       return $this->getResponder->handle(resource: UsersResource::class, repository: $this->userRepository, message: 'Users Get Successfully.', exception_message: 'Users List Get Error!', method: 'filter',is_paginate: true);
   }


    public function list()
    {
        return $this->getResponder->handle(
            resource: UsersListResource::class,
            repository: $this->userRepository,
            message: 'Users Get Successfully.',
            exception_message: 'Users List Get Error!',
            method: 'getWithCondition',
            parameters: [
                'data' => ['active' => 1],
                'columns' => ['id','first_name','last_name','email']
            ]
        );
    }

}
