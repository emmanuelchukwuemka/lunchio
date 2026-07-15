<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteEcommerceSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'categories' => 'array',
        'payment_methods' => 'array',
        'coupons_enabled' => 'boolean',
        'wishlist_enabled' => 'boolean',
        'product_reviews_enabled' => 'boolean',
        'related_products_enabled' => 'boolean',
        'customer_accounts' => 'boolean',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
