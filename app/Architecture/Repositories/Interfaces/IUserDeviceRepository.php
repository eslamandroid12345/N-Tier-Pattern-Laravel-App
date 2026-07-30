<?php

namespace App\Architecture\Repositories\Interfaces;

interface IUserDeviceRepository extends IAbstractRepository
{
    public function androidAndIosTokens($userIds);
    public function huaweiTokens($userIds);
    public function webTokens($userIds);
    public function removeDeviceTokens();

}
