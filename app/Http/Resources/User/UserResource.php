<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->full_name,
            'image' => $this->image,
            'national_id' => $this->national_id,
            'notification' => $this->notifications,
            'dark_mode' => $this->dark_mode,
            'language' => $this->language,
            'mobile' => $this->phone,
        ];
    }
}
