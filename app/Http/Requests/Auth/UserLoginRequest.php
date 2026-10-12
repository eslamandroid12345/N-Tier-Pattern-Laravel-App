<?php

namespace App\Http\Requests\Auth;

use App\Architecture\DTO\Auth\UserLoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'password' => ['required'],

        ];

        if(request()->is('dashboard/*')){
            return array_merge($rules, ['email' => 'required|email|exists:users,email']);
        }
        return array_merge($rules, ['phone' => 'required|numeric|exists:users,phone']);

    }

    public function toDTO(): UserLoginDTO
    {
        return UserLoginDTO::fromRequest($this->validated());
    }

    public function messages(): array
    {
        return [
            'phone.required'    => __('user/auth/login.phone.required'),
            'phone.numeric'     => __('user/auth/login.phone.numeric'),
            'phone.exists'      => __('user/auth/login.phone.exists'),
            'email.required'    => __('user/auth/login.email.required'),
            'email.email'       => __('user/auth/login.email.email'),
            'email.exists'      => __('user/auth/login.email.exists'),
            'password.required' => __('user/auth/login.password.required'),
        ];
    }

}
