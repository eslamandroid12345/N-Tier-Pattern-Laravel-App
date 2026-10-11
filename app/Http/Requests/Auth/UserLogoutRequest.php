<?php

namespace App\Http\Requests\Auth;

use App\Architecture\DTO\Auth\LogoutDTO;
use Illuminate\Foundation\Http\FormRequest;

class UserLogoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'device'       => ['sometimes', 'nullable','exists:user_devices,id'],
        ];
    }

    public function toDTO(): LogoutDTO
    {
        return LogoutDTO::fromRequest($this->validated());
    }

    public function messages(): array
    {
        return [
            'device.string'  => 'The device type must be a valid text string.',
            'device.in'      => 'The selected device type is invalid.',
        ];
    }
}
