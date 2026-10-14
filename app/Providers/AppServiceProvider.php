<?php

namespace App\Providers;

use App\Events\User\UserLogin;
use App\Listeners\User\UserLoginListener;
use App\Models\User;
use App\Observers\UserObserver;
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
         * Models With Observers
         */
        User::observe(UserObserver::class);

        /**
         * Event With Listeners
         */
        Event::listen(
            UserLogin::class,
            UserLoginListener::class
        );
    }
}
