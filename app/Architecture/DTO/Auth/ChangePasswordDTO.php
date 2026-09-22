<?php

namespace App\Architecture\DTO\Auth;

use App\Architecture\DTO\DataTransferObject;
use Illuminate\Support\Facades\Hash;

class ChangePasswordDTO extends DataTransferObject
{
    public ?string $old_password = null;
    public ?string $new_password = null;
    public static function fromRequest(array $request): self
    {
        return new self([
            'old_password'    => $request['old_password'] ?? null,
            'new_password'    => !empty($request['new_password']) ? Hash::make($request['new_password']) : null,
        ]);
    }
}
