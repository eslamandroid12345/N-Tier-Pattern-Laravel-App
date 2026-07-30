<?php

namespace App\Architecture\Services\Classes\User;

class UserWebService extends UserService
{
    public function getUserPlatform(): string
    {
        return 'Hi , I am in website platform';
    }

}
