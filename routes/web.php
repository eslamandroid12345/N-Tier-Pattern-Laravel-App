<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
   1-php artisan install:api
   2-php artisan migrate
   3-composer require laravel/sanctum
   4-php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   5- use  HasApiTokens in model user
   6-use Laravel\Sanctum\HasApiTokens;
   7-php artisan make:middleware  LocalizeApi
    8-composer require google/apiclient
   9-Added providers integration
   10-php artisan make:listener UserLoginListener --event=UserLogin

/*
    public function toDTO(): UserRegistrationDTO
    {
        return UserRegistrationDTO::fromRequest($this);
    }

 */
