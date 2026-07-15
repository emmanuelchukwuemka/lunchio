<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteHosting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
