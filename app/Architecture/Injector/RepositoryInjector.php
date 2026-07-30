<?php

namespace App\Architecture\Injector;

use App\Architecture\Repositories\Classes\NotificationRepository;
use App\Architecture\Repositories\Classes\OtpRepository;
use App\Architecture\Repositories\Classes\UserDeviceRepository;
use App\Architecture\Repositories\Interfaces\IAbstractRepository;
use App\Architecture\Repositories\Classes\AbstractRepository;

use App\Architecture\Repositories\Interfaces\INotificationRepository;
use App\Architecture\Repositories\Interfaces\IOtpRepository;
use App\Architecture\Repositories\Interfaces\IUserDeviceRepository;
use App\Architecture\Repositories\Interfaces\IUserRepository;
use App\Architecture\Repositories\Classes\UserRepository;
use App\Models\Notification;
use App\Models\Otp;
use App\Models\User;

use App\Models\UserDevice;
use Illuminate\Support\ServiceProvider;

class RepositoryInjector extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IAbstractRepository::class, AbstractRepository::class);
        $this->app->singleton(IUserRepository::class, function ($app) {
            return new UserRepository($app->make(User::class));
        });
        $this->app->singleton(IOtpRepository::class, function ($app) {
            return new OtpRepository($app->make(Otp::class));
        });
        $this->app->singleton(IUserDeviceRepository::class, function ($app) {
            return new UserDeviceRepository($app->make(UserDevice::class));
        });

        $this->app->singleton(INotificationRepository::class, function ($app) {
            return new NotificationRepository($app->make(Notification::class));
        });

    }
}
