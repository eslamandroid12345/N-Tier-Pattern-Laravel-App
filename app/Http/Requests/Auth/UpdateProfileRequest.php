<?php

namespace App\Http\Requests\Auth;

use App\Architecture\DTO\Auth\UpdateProfileDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'image'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp'],
        ];
    }
    public function toDTO(): UpdateProfileDTO
    {
        return UpdateProfileDTO::fromRequest($this->validated());
    }
    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name field is required.',
            'first_name.string'   => 'The first name must be a valid text string.',
            'first_name.max'      => 'The first name may not be greater than 255 characters.',
            'last_name.required'  => 'The last name field is required.',
            'last_name.string'    => 'The last name must be a valid text string.',
            'last_name.max'       => 'The last name may not be greater than 255 characters.',
            'image.image'         => 'The uploaded file must be a valid image.',
            'image.mimetypes'     => 'The image must be of type: jpeg, png, jpg, gif, svg, or webp.',
            'image.max'           => 'The image size may not exceed 5MB.',
        ];
    }
}
