<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deliverable extends Model
{
    public const TYPE_LOGO = 'logo';
    public const TYPE_BRAND_PDF = 'brand_pdf';
    public const TYPE_BUSINESS_CARD = 'business_card';
    public const TYPE_LANDING_PAGE = 'landing_page';
    public const TYPE_CAC_DOC = 'cac_doc';
    public const TYPE_SOCIAL_MEDIA = 'social_media';
    public const TYPE_CONTENT_PLAN = 'content_plan';
    public const TYPE_BUSINESS_PROFILE = 'business_profile';
    public const TYPE_OTHER = 'other';

    public const TYPES = [
        self::TYPE_LOGO,
        self::TYPE_BRAND_PDF,
        self::TYPE_BUSINESS_CARD,
        self::TYPE_LANDING_PAGE,
        self::TYPE_CAC_DOC,
        self::TYPE_SOCIAL_MEDIA,
        self::TYPE_CONTENT_PLAN,
        self::TYPE_BUSINESS_PROFILE,
        self::TYPE_OTHER,
    ];

    protected $fillable = [
        'order_id',
        'type',
        'title',
        'file_path',
        'original_filename',
        'version',
        'is_current',
        'uploaded_by',
        'notes',
        'sent_at',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'is_current' => 'boolean',
            'sent_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
