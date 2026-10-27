<?php

namespace App\Providers;

use App\Events\User\UserLogin;
use App\Listeners\User\UserLoginListener;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\Rule;

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
        Rule::macro('existsWithoutSoftDeletes', function ($table, $column = 'id') {
            return Rule::exists($table, $column)->whereNull('deleted_at');
        });

        /**
         * Event With Listeners
         */
        Event::listen(
            UserLogin::class,
            UserLoginListener::class
        );
    }
}
