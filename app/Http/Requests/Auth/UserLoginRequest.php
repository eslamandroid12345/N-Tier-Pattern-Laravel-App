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
            'phone.required' => 'The selected phone field is required.',
            'phone.numeric' => 'The selected phone must be a valid number.',
            'phone.exists' => 'The selected phone does not exist.',
            'email.required' => 'The selected email field is required.',
            'email.email' => 'The selected email must be a valid email.',
            'email.exists' => 'The selected email does not exist.',
            'password.required' => 'The password field is required.',
        ];
    }
}
