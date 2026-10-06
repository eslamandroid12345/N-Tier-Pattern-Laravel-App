<?php

namespace App\Architecture\Accessors\User;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait Image
{
    /*
   |----------------------------------------------------------------------------------------
   | MAKE TRAIT NAME IS ATTRIBUTE NAME FROM MODEL TO MAKE HIM SEARCH EASY FOR ANY ACCESSORS
   |----------------------------------------------------------------------------------------
   */
    public function image() : Attribute {
        return Attribute::get(
            get: function ($value) {
                if ($value !== null) {
                    return url($value);
                }
                return url('storage/img.png');
            }
        );
    }
}
