<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use  HasApiTokens,HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

    public function fullName() : Attribute {
        return Attribute::get(
            get: function () {
                return "{$this->first_name} {$this->last_name}";
            }
        );
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

}
