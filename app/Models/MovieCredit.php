<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieCredit extends Model
{
    protected $fillable = [
        'movie_id',
        'person_name',
        'role_type',
        'character_or_job_title',
        'billing_order',
    ];

    protected function casts(): array
    {
        return [
            'billing_order' => 'integer',
        ];
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
