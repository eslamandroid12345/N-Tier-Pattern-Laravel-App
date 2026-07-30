<?php

namespace App\Architecture\Repositories\Classes;

use App\Architecture\Repositories\Interfaces\IUserDeviceRepository;
use App\Enum\DeviceType;

class UserDeviceRepository extends AbstractRepository implements IUserDeviceRepository
{
    private function getTokens($userIds, array $devices)
    {
        return $this->prepareQuery()
            ->whereIn('user_id', (array) $userIds)
            ->whereIn('device', $devices)
            ->get(['user_id', 'token','device'])
            ->map(function ($item) {
                return [
                    'user_id' => $item->user_id,
                    'device' => $item->device->value,
                    'token' => $item->token,
                ];
            });
        /*
         [
         {
            "user_id": 18,
             "device" : "website",
            "token": "cRFH17xzTaGL4v6HMq2cV0:APA91bG-zk2nBn4gBiRePAII1Z2th_X7fTQR0AiPDGEeeSaSaq_EV3YYW5qk_xs5b07Wy6hSLVBKfBqCxE_hffkEbe-D6WMvsP1MDSANDMSAJD"
         }
         ]
       */
    }

    public function androidAndIosTokens($userIds)
    {
        return $this->getTokens($userIds, [
            DeviceType::ANDROID->value,
            DeviceType::IOS->value,
        ]);
    }

    public function huaweiTokens($userIds)
    {
        return $this->getTokens($userIds, [
            DeviceType::HUAWEI->value,
        ]);
    }

    public function webTokens($userIds)
    {
        return $this->getTokens($userIds, [
            DeviceType::WEBSITE->value,
        ]);
    }

    public function removeDeviceTokens()
    {
        return $this->prepareQuery()
            ->where('user_id',auth()->id())
            ->delete();
    }
}
