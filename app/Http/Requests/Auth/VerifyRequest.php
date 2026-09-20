<?php

namespace App\Http\Requests\Auth;

use App\Architecture\DTO\Auth\VerifyDTO;
use App\Enum\DeviceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone'        => ['required', 'numeric', 'exists:users,phone'],
            'code'         => ['required', 'numeric', 'exists:otps,code'],
            'device'       => ['sometimes', 'nullable', 'string', Rule::in(DeviceType::values())],
            'token'        => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function toDTO(): VerifyDTO
    {
        return VerifyDTO::fromRequest($this->validated());
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'The phone number field is required.',
            'phone.numeric'  => 'The phone number must contain digits only.',
            'phone.exists'   => 'The provided phone number is not registered.',
            'code.required'  => 'The verification code field is required.',
            'code.numeric'   => 'The verification code must be a number.',
            'code.exists'    => 'The entered verification code is invalid or expired.',
            'device.string'  => 'The device type must be a valid text string.',
            'device.in'      => 'The selected device type is invalid.',
            'token.string' => 'The device token must be a valid text string.',
        ];
    }
}
