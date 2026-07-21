<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    public const STATUS_LEAD = 'lead';
    public const STATUS_CUSTOMER = 'customer';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'status',
        'source',
        'notes',
        'last_contacted_at',
    ];

    protected function casts(): array
    {
        return [
            'last_contacted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(ContactFollowUp::class)->latest();
    }
}
