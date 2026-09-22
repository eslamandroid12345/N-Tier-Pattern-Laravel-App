<?php

namespace App\Http\Requests\Auth;

use App\Architecture\DTO\Auth\ResendCodeDTO;
use App\Architecture\DTO\Auth\UserLoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class ResendCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return  [
            'phone' => 'required|numeric|exists:users,phone',
        ];
    }

    public function toDTO(): ResendCodeDTO
    {
        return ResendCodeDTO::fromRequest($this->validated());
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'The selected phone field is required.',
            'phone.email' => 'The selected phone must be a valid number.',
            'phone.exists' => 'The selected phone does not exist.',
        ];
    }
}
