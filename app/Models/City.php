<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'province_or_state',
        'country_code',
        'currency_code',
        'timezone',
        'center_latitude',
        'center_longitude',
        'tagline',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'center_latitude' => 'float',
            'center_longitude' => 'float',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function cinemas(): HasMany
    {
        return $this->hasMany(Cinema::class);
    }
}
