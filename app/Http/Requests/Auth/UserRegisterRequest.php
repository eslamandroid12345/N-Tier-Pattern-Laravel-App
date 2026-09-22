<?php

namespace App\Http\Requests\Auth;

use App\Architecture\DTO\Auth\UserRegisterDTO;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'  => ['required', 'string', 'max:100'],
            'last_name'   => ['required', 'string', 'max:100'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'       => ['required', 'string', 'numeric', 'unique:users,phone'],
            'password'    => ['required', 'string', 'min:8'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp'],
            'role_id'     => ['nullable', 'integer', 'exists:roles,id'],
            'national_id' => ['nullable', 'numeric', 'unique:users,national_id'],
        ];
    }

    public function toDTO(): UserRegisterDTO
    {
        return UserRegisterDTO::fromRequest($this->validated());
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.string'   => 'First name must be a valid text string.',
            'first_name.max'      => 'First name may not be greater than 100 characters.',
            'last_name.required'  => 'Last name is required.',
            'last_name.string'    => 'Last name must be a valid text string.',
            'last_name.max'       => 'Last name may not be greater than 100 characters.',
            'email.required'      => 'Email address is required.',
            'email.email'         => 'Please provide a valid email address.',
            'email.unique'        => 'This email address is already registered.',
            'phone.required'      => 'Phone number is required.',
            'phone.numeric'       => 'Phone number must contain digits only.',
            'phone.unique'        => 'This phone number is already registered.',
            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least 8 characters long.',
            'image.image'         => 'The uploaded file must be a valid image.',
            'image.mimes'         => 'Image must be of type: jpeg, png, jpg, gif, or webp.',
            'role_id.integer'     => 'Role ID must be an integer.',
            'role_id.exists'      => 'The selected role ID does not exist.',
            'national_id.numeric' => 'National ID must contain digits only.',
            'national_id.unique'  => 'This National ID is already registered.',
        ];
    }
}
