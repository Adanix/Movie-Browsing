<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Auditorium extends Model
{
    protected $table = 'auditoriums';

    protected $fillable = [
        'cinema_id',
        'name',
        'screen_format',
        'sound_system',
        'total_capacity',
        'rows_count',
        'seats_per_row',
        'is_step_free',
    ];

    protected function casts(): array
    {
        return [
            'total_capacity' => 'integer',
            'rows_count' => 'integer',
            'seats_per_row' => 'integer',
            'is_step_free' => 'boolean',
        ];
    }

    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}
