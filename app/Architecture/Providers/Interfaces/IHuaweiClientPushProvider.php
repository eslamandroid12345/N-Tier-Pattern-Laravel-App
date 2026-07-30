<?php

namespace App\Architecture\Providers\Interfaces;

interface IHuaweiClientPushProvider
{
    public function sendNotification($deviceToken, $title, $body, $data = []);

}
