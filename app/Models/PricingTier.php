<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingTier extends Model
{
    protected $fillable = [
        'code',
        'name',
        'currency_code',
        'base_price',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
        ];
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }

    public function formattedPrice(): string
    {
        if ($this->currency_code === 'IDR') {
            return 'IDR ' . number_format($this->base_price, 0, ',', '.');
        }
        return '$' . number_format($this->base_price, 2);
    }
}
