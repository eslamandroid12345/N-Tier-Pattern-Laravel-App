<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserDestroyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge($this->route()->parameters());
    }

    public function rules(): array
    {
        return [
            'user'          =>  ['string', Rule::existsWithoutSoftDeletes('users', 'uuid')],
        ];
    }

    public function getUuid(): mixed
    {
        return $this->input('user');
    }

    public function messages(): array
    {
        return [
            'user.string'                  => __('user/actions/user.user.string'),
            'user.exists'                  => __('user/actions/user.user.exists'),
        ];
    }


}
