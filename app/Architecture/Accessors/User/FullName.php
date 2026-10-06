<?php

namespace App\Architecture\Accessors\User;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait FullName
{
    public function fullName() : Attribute {
        return Attribute::get(
            get: function () {
                return "{$this->first_name} {$this->last_name}";
            }
        );
    }
}
