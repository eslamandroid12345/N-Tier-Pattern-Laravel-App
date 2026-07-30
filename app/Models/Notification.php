<?php

namespace App\Models;

use App\Enum\NotificationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'item',
        'type',
        'is_read',
        'data',
    ];
    protected $casts = [
        'is_read' => 'boolean',
        'type' => NotificationType::class,
        'data' => 'json'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
