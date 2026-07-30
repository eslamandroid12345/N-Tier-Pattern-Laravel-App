<?php

namespace App\Architecture\Repositories\Interfaces;

interface IUserRepository extends IAbstractRepository
{
    public function filter();
    public function getByMobileNumber($mobile);
}
