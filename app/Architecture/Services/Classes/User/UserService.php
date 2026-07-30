<?php

namespace App\Architecture\Services\Classes\User;

use App\Architecture\Repositories\Interfaces\IUserRepository;
use App\Architecture\Responder\IGetResponder;
use App\Architecture\Services\Interfaces\IUserService;
use App\Http\Resources\User\UserResource;

abstract class UserService implements IUserService
{
   public function __construct(
       private readonly IUserRepository $userRepository,
       private readonly IGetResponder $getResponder
   )
   {
   }

   public function getUsers()
   {
       return $this->getResponder->handle(resource: UserResource::class,repository: $this->userRepository,method: 'all',is_paginate: true);
   }

}
