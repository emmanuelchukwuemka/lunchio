<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'tagline',
        'description',
        'price_one_time',
        'price_recurring',
        'recurring_interval',
        'currency',
        'is_recurring',
        'most_popular',
        'turnaround_time',
        'sort_order',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'price_one_time' => 'decimal:2',
            'price_recurring' => 'decimal:2',
            'is_recurring' => 'boolean',
            'most_popular' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'package_feature')
            ->withPivot(['included', 'value'])
            ->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'package_interest_id');
    }
}
