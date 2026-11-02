<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cinema extends Model
{
    protected $fillable = [
        'city_id',
        'manager_user_id',
        'name',
        'slug',
        'neighborhood',
        'address_line',
        'latitude',
        'longitude',
        'phone_number',
        'transit_and_parking_note',
        'opening_hours_json',
        'amenities_json',
        'architectural_style',
        'hero_badge',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'opening_hours_json' => 'array',
            'amenities_json' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_user_id');
    }

    public function auditoriums(): HasMany
    {
        return $this->hasMany(Auditorium::class);
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }

    public function isBoxOfficeOpen(): bool
    {
        $hours = $this->opening_hours_json ?? ['open' => '10:00', 'close' => '23:30'];
        $now = now()->setTimezone($this->city->timezone ?? 'Asia/Jakarta')->format('H:i');
        return $now >= ($hours['open'] ?? '10:00') && $now <= ($hours['close'] ?? '23:30');
    }
}
