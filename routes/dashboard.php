<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    Route::get('home', [AuthController::class, 'home'])->name('dashboard.home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

});

Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'view'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('admin.auth.login');
});


/*
   1-php artisan install:api
   2-php artisan migrate
   3-composer require laravel/sanctum
   4-php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   5- use  HasApiTokens in model user
   6-use Laravel\Sanctum\HasApiTokens in model user;
   7-php artisan make:middleware  LocalizeApi
    8-composer require google/apiclient - for firebase
   9-Added providers integration
   10-php artisan make:listener UserLoginListener --event=UserLogin

/*
    public function toDTO(): UserRegistrationDTO
    {
        return UserRegistrationDTO::fromRequest($this->validated());
    }

 */
