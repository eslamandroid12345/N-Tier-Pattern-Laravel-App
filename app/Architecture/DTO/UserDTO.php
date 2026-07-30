<?php

namespace App\Architecture\DTO;

use Illuminate\Support\Facades\Hash;

class UserDTO extends DataTransferObject
{
    public ?string $image;
    public ?string $first_name;
    public ?string $last_name;
    public ?string $mobile_number;
    public ?string $email;
    public ?string $password;

    public ?int $role_id;
    static public function fromRequest(array $request): self
    {
        return new self(
            [
                'image' => $request['image'] ?? null,
                'first_name' => $request['first_name'] ?? null,
                'last_name' => $request['last_name'] ?? null,
                'mobile_number' => $request['mobile_number'] ?? null,
                'email' => $request['email'] ?? null,
                'password' => request()->has('password') ? Hash::make($request['password']) : null,
                'role_id' => $request['role_id'] ?? null,
            ]
        );
    }
}
