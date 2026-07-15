<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branding()
    {
        return $this->hasOne(WebsiteBranding::class);
    }

    public function pages()
    {
        return $this->hasMany(WebsitePage::class);
    }

    public function features()
    {
        return $this->hasMany(WebsiteFeature::class);
    }

    public function domain()
    {
        return $this->hasOne(WebsiteDomain::class);
    }

    public function hosting()
    {
        return $this->hasOne(WebsiteHosting::class);
    }

    public function ecommerceSetting()
    {
        return $this->hasOne(WebsiteEcommerceSetting::class);
    }
}
