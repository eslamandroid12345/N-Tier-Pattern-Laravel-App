<?php

namespace App\Architecture\Injector;

use App\Architecture\Services\Classes\Auth\AuthDashboardService;
use App\Architecture\Services\Classes\Auth\AuthMobileService;
use App\Architecture\Services\Classes\Auth\AuthService;
use App\Architecture\Services\Classes\Auth\AuthWebService;
use App\Architecture\Services\Classes\User\UserMobileService;
use App\Architecture\Services\Classes\User\UserService;
use App\Architecture\Services\Classes\User\UserWebService;
use Illuminate\Support\ServiceProvider;

class PlatformServiceInjector extends ServiceProvider
{
    private const SERVICES = [
        UserService::class => [
            'website'   => UserWebService::class,
            'mobile'    => UserMobileService::class,
        ],

        AuthService::class => [
            'website'    => AuthWebService::class,//web service
            'mobile'     => AuthMobileService::class,//mobile service
            'dashboard'  => AuthDashboardService::class,//dashboard service
        ],
    ];

    private const DEFAULT_PLATFORM = 'website';

    public function detectPlatform(array $implementations): string
    {
        if (request()->is('api/mobile/*')) {
            return 'mobile';
        }

        if (request()->is('dashboard/*')) {
            return 'dashboard';
        }

        return self::DEFAULT_PLATFORM;
    }

    public function register(): void
    {
        foreach (self::SERVICES as $interface => $implementations) {
            $this->app->singleton($interface, function ($app) use ($interface, $implementations) {
                $platform = $this->detectPlatform($implementations);//dashboard or website or mobile

                $implementation = $implementations[$platform]//$implementations['mobile']
                 ?? $implementations[self::DEFAULT_PLATFORM];

                return $app->make($implementation);
            });
        }
    }

    public function boot(): void
    {
        //
    }
}
