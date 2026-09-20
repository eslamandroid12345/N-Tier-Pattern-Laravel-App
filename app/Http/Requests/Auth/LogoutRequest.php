<?php

namespace App\Http\Requests\Auth;

use App\Architecture\DTO\Auth\LogoutDTO;
use App\Architecture\DTO\Auth\VerifyDTO;
use App\Enum\DeviceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LogoutRequest extends FormRequest
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
