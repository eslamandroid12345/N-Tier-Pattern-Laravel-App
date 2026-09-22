<?php

namespace App\Architecture\DTO\Auth;

use App\Architecture\DTO\DataTransferObject;
use Illuminate\Http\UploadedFile;

class UpdateProfileDTO extends DataTransferObject
{
    public ?string $first_name = null;
    public ?string $last_name = null;
    public mixed $image = null;
    public static function fromRequest(array $request): self
    {
        return new self([
            'first_name' => $request['first_name'] ?? null,
            'last_name'  => $request['last_name'] ?? null,
            'image'      => $request['image'] ?? null,
        ]);
    }
}
