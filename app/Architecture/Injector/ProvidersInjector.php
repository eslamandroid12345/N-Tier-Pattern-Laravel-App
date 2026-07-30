<?php

namespace App\Architecture\Injector;

use App\Architecture\Providers\Classes\HuaweiClientPushProvider;
use App\Architecture\Providers\Interfaces\IHuaweiClientPushProvider;
use Illuminate\Support\ServiceProvider;
use App\Architecture\Providers\Classes\FirebaseProvider;
use App\Architecture\Providers\Interfaces\IFirebaseProvider;

class ProvidersInjector extends ServiceProvider
{
    public function register()
    {

        $this->app->singleton(IFirebaseProvider::class, FirebaseProvider::class);
        $this->app->singleton(IHuaweiClientPushProvider::class, HuaweiClientPushProvider::class);
    }
}
