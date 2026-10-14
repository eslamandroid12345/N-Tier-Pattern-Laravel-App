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
            'image.image'                  => __('user/actions/user.image.image'),
            'image.mimes'                  => __('user/actions/user.image.mimes'),
            'image.max'                    => __('user/actions/user.image.max'),
            'first_name.required'          => __('user/actions/user.first_name.required'),
            'first_name.string'            => __('user/actions/user.first_name.string'),
            'first_name.max'               => __('user/actions/user.first_name.max'),
            'last_name.required'           => __('user/actions/user.last_name.required'),
            'last_name.string'             => __('user/actions/user.last_name.string'),
            'last_name.max'                => __('user/actions/user.last_name.max'),
            'email.required'               => __('user/actions/user.email.required'),
            'email.string'                 => __('user/actions/user.email.string'),
            'email.email'                  => __('user/actions/user.email.email'),
            'email.max'                    => __('user/actions/user.email.max'),
            'email.unique'                 => __('user/actions/user.email.unique'),
            'phone.required'               => __('user/actions/user.phone.required'),
            'phone.numeric'                => __('user/actions/user.phone.numeric'),
            'password.required'            => __('user/actions/user.password.required'),
            'password.string'              => __('user/actions/user.password.string'),
            'password.min'                 => __('user/actions/user.password.min'),
            'role_id.integer'              => __('user/actions/user.role_id.integer'),
            'role_id.exists'               => __('user/actions/user.role_id.exists'),
            'national_id.integer'          => __('user/actions/user.national_id.integer'),
            'national_id.digits_between'   => __('user/actions/user.national_id.digits_between'),
            'national_id.unique'           => __('user/actions/user.national_id.unique'),
        ];
    }


}
