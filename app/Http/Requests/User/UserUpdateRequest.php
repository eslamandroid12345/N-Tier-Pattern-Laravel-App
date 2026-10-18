<?php

namespace App\Http\Requests\User;

use App\Architecture\DTO\User\UserDTO;
use App\Architecture\Repositories\Interfaces\IUserRepository;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /*
   |--------------------------------------------------------------------------
   جلب المستخدم مرة واحدة فقط بالـ UUID لتوفير الاستعلامات |
   |--------------------------------------------------------------------------
   */
    protected function getTargetUser(): ?User
    {

       $userRepository = app(IUserRepository::class);

       return $userRepository->getData(
           ['uuid' => $this->getUuid()],
           columns:['id', 'uuid', 'email', 'phone', 'national_id'],
           isFirst: true
       );

    }

    public function rules(): array
    {
        $user = $this->getTargetUser();
        $userId = $user?->id;

        $emailRules = ['sometimes', 'string', 'email', 'max:255'];
        if ($user && $this->filled('email') && $this->input('email') != $user->email) {
            $emailRules[] = Rule::unique('users', 'email')->ignore($userId);
        }


        $phoneRules = ['sometimes', 'string'];
        if ($user && $this->filled('phone') && $this->input('phone') != $user->phone) {
            $phoneRules[] = Rule::unique('users', 'phone')->ignore($userId);
        }

        $nationalIdRules = ['sometimes', 'string', 'digits_between:1,20'];
        if ($user && $this->filled('national_id') && $this->input('national_id') != $user->national_id) {
            $nationalIdRules[] = Rule::unique('users', 'national_id')->ignore($userId);
        }

        return [
            'user'          =>  ['required','string'],
            'image'         => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'first_name'    => ['sometimes', 'string', 'max:100'],
            'last_name'     => ['sometimes', 'string', 'max:100'],
            'email'         => $emailRules,
            'phone'         => $phoneRules,
            'password'      => ['sometimes', 'string', 'min:8'],
            'role_id'       => ['sometimes', 'integer', 'exists:roles,id'],
            'national_id'   => $nationalIdRules,
            'dark_mode'     => ['sometimes', 'boolean'],
            'notifications'      => ['sometimes','boolean'],
            'language'      => ['sometimes','boolean'],
            'active'      => ['sometimes','boolean'],
        ];
    }

    public function toDTO(): UserDTO
    {
        return UserDTO::fromRequest($this->validated());
    }

    protected function prepareForValidation(): void
    {
        $this->merge($this->route()->parameters());

        if (!$this->getTargetUser()) {
            abort(404, __('user/actions/user.user.exists'));
        }
    }

    public function getUuid(): mixed
    {
        return $this->input('user');
    }

    public function messages(): array
    {
        return [
            'user.string'                  => __('user/actions/user.user.string'),
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
            'phone.unique'                 => __('user/actions/user.phone.unique'),
            'password.required'            => __('user/actions/user.password.required'),
            'password.string'              => __('user/actions/user.password.string'),
            'password.min'                 => __('user/actions/user.password.min'),
            'role_id.integer'              => __('user/actions/user.role_id.integer'),
            'role_id.exists'               => __('user/actions/user.role_id.exists'),
            'national_id.integer'          => __('user/actions/user.national_id.integer'),
            'national_id.digits_between'   => __('user/actions/user.national_id.digits_between'),
            'national_id.unique'           => __('user/actions/user.national_id.unique'),
            'dark_mode.boolean'            => __('user/actions/user.dark_mode.boolean'),
            'notifications.boolean'        => __('user/actions/user.notifications.boolean'),
            'language.boolean'             => __('user/actions/user.language.boolean'),
            'active.boolean'               => __('user/actions/user.active.boolean'),
        ];
    }


}
