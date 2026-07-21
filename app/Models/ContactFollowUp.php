<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactFollowUp extends Model
{
    protected $fillable = [
        'contact_id',
        'note',
        'follow_up_date',
    ];

    protected function casts(): array
    {
        return [
            'follow_up_date' => 'date',
        ];
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
