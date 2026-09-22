<?php

namespace App\Architecture\Services\Interfaces;
interface IAuthService
{
    public function register(array $data);
    public function login(array $data);
    public function verify(array $data);
    public function resendCode(array $data);
    public function changePassword(array $data);
    public function profile();
    public function updateProfile(array $data);
    public function logout(array $data);

}
