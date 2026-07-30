<?php

namespace App\Architecture\Injector;

use App\Architecture\Services\Classes\Auth\AuthService;
use App\Architecture\Services\Classes\User\UserService;
use App\Architecture\Services\Interfaces\IAuthService;
use App\Architecture\Services\Interfaces\IUserService;
use App\Architecture\Services\Mutual\Classes\FileManagerService;
use App\Architecture\Services\Mutual\Classes\OtpService;
use App\Architecture\Services\Mutual\Interfaces\IFileManagerService;
use App\Architecture\Services\Mutual\Interfaces\IOtpService;
use Illuminate\Support\ServiceProvider;

class ServicesInjector extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IFileManagerService::class,FileManagerService::class);
        $this->app->singleton(IAuthService::class,AuthService::class);
        $this->app->singleton(IUserService::class,UserService::class);
        $this->app->singleton(IOtpService::class,OtpService::class);
    }
}
