<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('resend/code', [AuthController::class, 'resendCode'])->name('resend.code');
Route::post('verify', [AuthController::class, 'verify'])->name('verify');
Route::middleware(['auth:sanctum'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    Route::get('my-profile', [AuthController::class, 'profile']);
    Route::put('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::resource('users', UserController::class);
    Route::get('users-list', [UserController::class,'list']);
    Route::post('logout', [AuthController::class, 'logout']);
});
