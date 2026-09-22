<?php

namespace App\Http\Requests\Auth;

use App\Architecture\DTO\Auth\ChangePasswordDTO;
use App\Architecture\DTO\Auth\UserLoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed', 'different:old_password'],
        ];
    }
    public function toDTO(): ChangePasswordDTO
    {
        return ChangePasswordDTO::fromRequest($this->validated());
    }
    public function messages(): array
    {
        return [
            'old_password.required' => 'The current password field is required.',
            'new_password.required'  => 'The new password field is required.',
            'new_password.min'       => 'The new password must be at least 8 characters long.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
            'new_password.different' => 'The new password must be different from the current password.',
        ];
    }
}
