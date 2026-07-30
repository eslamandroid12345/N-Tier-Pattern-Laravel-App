<?php

namespace App\Providers;

use App\Events\User\UserLogin;
use App\Listeners\User\UserLoginListener;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(
            UserLogin::class,
            UserLoginListener::class
        );//Event with listener
    }
}
