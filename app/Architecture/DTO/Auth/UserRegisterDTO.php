<?php

namespace App\Architecture\DTO\Auth;

use App\Architecture\DTO\DataTransferObject;
use Illuminate\Support\Facades\Hash;

class UserRegisterDTO extends DataTransferObject
{

    public ?string $image = null;
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $password = null;

    public ?int $role_id = null;
    public ?int $national_id = null;

    public static function fromRequest(array $request): self
    {
        return new self([
            'image'         => $request['image'] ?? null,
            'first_name'    => $request['first_name'] ?? null,
            'last_name'     => $request['last_name'] ?? null,
            'email'         => $request['email'] ?? null,
            'phone'         => $request['phone'] ?? null,
            'password'      => !empty($request['password']) ? Hash::make($request['password']) : null,
            'role_id'       => isset($request['role_id']) ? (int) $request['role_id'] : null,
            'national_id'   => isset($request['national_id']) ? (int) $request['national_id'] : null,
        ]);
    }
}
