<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'business_name',
        'package_interest_id',
        'source',
        'status',
        'payload',
        'converted_user_id',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    public function packageInterest(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_interest_id');
    }

    public function convertedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'converted_user_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class)->latest();
    }
}
