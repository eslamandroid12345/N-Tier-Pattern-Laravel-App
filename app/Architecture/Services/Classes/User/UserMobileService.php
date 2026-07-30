<?php

namespace App\Architecture\Services\Classes\User;

class UserMobileService extends UserService
{
    public function getUserPlatform(): string
    {
        return 'Hi , I am in mobile platform';
    }

}
