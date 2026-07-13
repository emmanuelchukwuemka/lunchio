<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';

    public const TYPE_ONE_TIME = 'one_time';
    public const TYPE_SUBSCRIPTION = 'subscription';

    public const PROVIDER_PAYSTACK = 'paystack';
    public const PROVIDER_FLUTTERWAVE = 'flutterwave';

    protected $fillable = [
        'user_id',
        'order_id',
        'package_id',
        'provider',
        'provider_reference',
        'amount',
        'currency',
        'status',
        'type',
        'meta',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'meta' => 'array',
            'paid_at' => 'datetime',
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

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
