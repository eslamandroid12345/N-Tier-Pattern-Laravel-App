<?php

namespace App\Architecture\Providers\Interfaces;

interface IFirebaseProvider
{
    public function handle($fcm, $title, $content, $extraData = []);
}
