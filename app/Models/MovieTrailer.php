<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieTrailer extends Model
{
    protected $fillable = [
        'movie_id',
        'title',
        'trailer_type',
        'duration_seconds',
        'video_stream_url',
        'storyboard_config_json',
        'is_primary',
        'view_count',
    ];

    protected function casts(): array
    {
        return [
            'duration_seconds' => 'integer',
            'storyboard_config_json' => 'array',
            'is_primary' => 'boolean',
            'view_count' => 'integer',
        ];
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
