<?php

namespace App\Architecture\DTO\Auth;

use App\Architecture\DTO\DataTransferObject;

class UserLoginDTO extends DataTransferObject
{

    public ?string $phone = null;
    public ?string $password = null;



    public static function fromRequest(array $request): self
    {
        return new self([
            'phone'         => $request['phone'] ?? null,
            'password'      => $request['password'] ?? null,
        ]);
    }
}
