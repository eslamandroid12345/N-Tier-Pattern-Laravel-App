<?php

namespace App\Http\Requests\User;

use App\Architecture\DTO\User\UserDTO;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'         => ['required', 'numeric'],
            'password'      => ['required', 'string', 'min:8'],
            'role_id'       => ['nullable', 'integer', 'exists:roles,id'],
            'national_id'   => ['nullable', 'integer', 'digits_between:1,20', 'unique:users,national_id'],
        ];
    }

    public function toDTO(): UserDTO
    {
        return UserDTO::fromRequest($this->validated());
    }

    public function messages(): array
    {
        return [
            'image.image'                  => 'The uploaded file must be an image.',
            'image.mimes'                  => 'The image must be a file of type: jpg, jpeg, png, or webp.',
            'image.max'                    => 'The image size may not be greater than 2MB.',
            'first_name.required'          => 'The first name is required.',
            'first_name.string'            => 'The first name must be a valid text string.',
            'first_name.max'               => 'The first name must not exceed 100 characters.',
            'last_name.required'           => 'The last name is required.',
            'last_name.string'             => 'The last name must be a valid text string.',
            'last_name.max'                => 'The last name must not exceed 100 characters.',
            'email.required'               => 'The email address is required.',
            'email.string'                 => 'The email address must be a valid text string.',
            'email.email'                  => 'Please provide a valid email address.',
            'email.max'                    => 'The email address must not exceed 255 characters.',
            'email.unique'                 => 'This email is already registered.',
            'phone.required'               => 'The phone number is required.',
            'phone.numeric'                => 'The phone number must contain only numbers.',
            'password.required'            => 'The password is required.',
            'password.string'              => 'The password must be a valid string.',
            'password.min'                 => 'The password must be at least 8 characters long.',
            'role_id.integer'              => 'The role ID must be a valid integer.',
            'role_id.exists'               => 'The selected role does not exist.',
            'national_id.integer'          => 'The national ID must be an integer.',
            'national_id.digits_between'   => 'The national ID must be between 1 and 20 digits.',
            'national_id.unique'           => 'This national ID is already registered.',
        ];
    }

}
