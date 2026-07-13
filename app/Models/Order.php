<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_IN_REVIEW = 'in_review';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_DELIVERED = 'delivered';

    public const STATUSES = [
        self::STATUS_SUBMITTED,
        self::STATUS_IN_PROGRESS,
        self::STATUS_IN_REVIEW,
        self::STATUS_APPROVED,
        self::STATUS_DELIVERED,
    ];

    protected $fillable = [
        'reference',
        'user_id',
        'package_id',
        'assigned_staff_id',
        'status',
        'submitted_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class)->latest('created_at');
    }

    public function deliverables(): HasMany
    {
        return $this->hasMany(Deliverable::class);
    }

    public function adminNotes(): HasMany
    {
        return $this->hasMany(AdminNote::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function intakeDraft(): HasOne
    {
        return $this->hasOne(IntakeDraft::class);
    }

    public function getBusinessNameAttribute()
    {
        return $this->intakeDraft?->data['business_name'] ?? 'My Business';
    }

    public function getBusinessDescriptionAttribute()
    {
        return $this->intakeDraft?->data['business_description'] ?? null;
    }

    public function getIndustryAttribute()
    {
        return $this->intakeDraft?->data['industry'] ?? 'N/A';
    }

    public function getBusinessStageAttribute()
    {
        return $this->intakeDraft?->data['business_stage'] ?? 'N/A';
    }

    public function getLocationAttribute()
    {
        return $this->intakeDraft?->data['location'] ?? 'N/A';
    }

    public function getTargetAudienceAttribute()
    {
        return $this->intakeDraft?->data['target_audience'] ?? 'N/A';
    }
}
