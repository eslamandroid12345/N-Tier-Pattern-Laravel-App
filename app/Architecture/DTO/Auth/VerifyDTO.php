<?php

namespace App\Architecture\DTO\Auth;

use App\Architecture\DTO\DataTransferObject;

class VerifyDTO extends DataTransferObject
{
    public ?string $phone = null;
    public ?int $code = null;
    public ?string $device = null;
    public ?string $token = null;

    public static function fromRequest(array $request): self
    {
        return new self([
            'phone'        => isset($request['phone']) ? (string) $request['phone'] : null,
            'code'         => isset($request['code']) ? (int) $request['code'] : null,
            'device'       => $request['device'] ?? null,
            'token'        => $request['token'] ?? null,
        ]);
    }
}
