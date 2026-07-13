<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntakeDraft extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'current_step',
        'data',
        'is_draft',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'is_draft' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
