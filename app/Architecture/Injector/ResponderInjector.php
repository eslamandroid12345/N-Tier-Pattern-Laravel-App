<?php

namespace App\Architecture\Injector;

use App\Architecture\Responder\ApiHttpResponder;
use App\Architecture\Responder\GetResponder;
use App\Architecture\Responder\IApiHttpResponder;
use App\Architecture\Responder\IGetResponder;
use Illuminate\Support\ServiceProvider;

class ResponderInjector extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IApiHttpResponder::class, ApiHttpResponder::class);
        $this->app->singleton(IGetResponder::class, GetResponder::class);
    }
}
