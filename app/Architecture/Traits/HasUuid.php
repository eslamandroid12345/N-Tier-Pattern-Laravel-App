<?php

namespace App\Architecture\Traits;

use Illuminate\Support\Str;

trait HasUuid
{

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$this->uuid ?? 'uuid'})) {
                $model->{$this->uuid ?? 'uuid'} = Str::uuid()->toString();
            }
        });
    }

    public function getIncrementing()
    {
        return true;
    }
}
