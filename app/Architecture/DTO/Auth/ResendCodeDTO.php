<?php

namespace App\Architecture\DTO\Auth;

use App\Architecture\DTO\DataTransferObject;

class ResendCodeDTO extends DataTransferObject
{

    public ?string $phone = null;

    public static function fromRequest(array $request): self
    {
        return new self([
            'phone'         => $request['phone'] ?? null,
        ]);
    }
}
