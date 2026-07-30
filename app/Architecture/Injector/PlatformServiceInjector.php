<?php

namespace App\Architecture\Injector;

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
            'website' =>  UserWebService::class,
            'mobile' =>  UserMobileService::class//Add more platforms here
        ],
        AuthService::class => [
            'website' =>  AuthWebService::class,
            'mobile' =>   AuthMobileService::class
        ],

    ];

    public function detectPlatform($webService,$mobileService)
    {
        if(request()->is('api/website/*')){
           return $webService;
        }

        if(request()->is('api/mobile/*')){
            return $mobileService;
        }//Add more platforms here

        return $webService;
    }


    public function register(): void
    {
        foreach (self::SERVICES as $interface => $implementations) {
            $webService = $implementations['website'];
            $mobileService = $implementations['mobile'];//Add more platforms here

            $this->app->singleton($interface, function ($app) use ($webService, $mobileService) {
                return $app->make($this->detectPlatform($webService, $mobileService));//Add more platforms here
            });
        }
    }

    public function boot(): void
    {
        //
    }
}
