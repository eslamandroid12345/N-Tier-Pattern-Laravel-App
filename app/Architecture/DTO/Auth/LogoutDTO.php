<?php

namespace App\Architecture\DTO\Auth;

use App\Architecture\DTO\DataTransferObject;

class LogoutDTO extends DataTransferObject
{
    public ?string $device = null;

    public static function fromRequest(array $request): self
    {
        return new self([
            'device'       => $request['device'] ?? null,
        ]);
    }
}
