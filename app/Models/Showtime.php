<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Showtime extends Model
{
    protected $fillable = [
        'movie_id',
        'cinema_id',
        'auditorium_id',
        'pricing_tier_id',
        'screening_date',
        'starts_at',
        'ends_at',
        'presentation_format',
        'audio_language_code',
        'subtitle_language_code',
        'is_captioned_cc',
        'is_audio_described_ad',
        'is_sensory_friendly_sf',
        'is_parent_baby_pb',
        'available_seats_estimate',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'screening_date' => 'date',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_captioned_cc' => 'boolean',
            'is_audio_described_ad' => 'boolean',
            'is_sensory_friendly_sf' => 'boolean',
            'is_parent_baby_pb' => 'boolean',
            'available_seats_estimate' => 'integer',
        ];
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function auditorium(): BelongsTo
    {
        return $this->belongsTo(Auditorium::class);
    }

    public function pricingTier(): BelongsTo
    {
        return $this->belongsTo(PricingTier::class);
    }

    public function formattedTime(): string
    {
        return $this->starts_at->format('H:i');
    }

    public function accessibilityBadges(): array
    {
        $badges = [];
        if ($this->is_captioned_cc) $badges[] = ['code' => 'CC', 'name' => 'Closed Captioned'];
        if ($this->is_audio_described_ad) $badges[] = ['code' => 'AD', 'name' => 'Audio Described'];
        if ($this->is_sensory_friendly_sf) $badges[] = ['code' => 'SF', 'name' => 'Sensory Friendly'];
        if ($this->is_parent_baby_pb) $badges[] = ['code' => 'PB', 'name' => 'Parent & Baby'];
        return $badges;
    }
}
