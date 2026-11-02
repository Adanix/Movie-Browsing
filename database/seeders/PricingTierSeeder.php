<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingTier;

class PricingTierSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            [
                'code' => 'matinee_id',
                'name' => 'Matinee Early Bird (Before 17:00)',
                'currency_code' => 'IDR',
                'base_price' => 50000.00,
            ],
            [
                'code' => 'evening_id',
                'name' => 'Evening Feature',
                'currency_code' => 'IDR',
                'base_price' => 65000.00,
            ],
            [
                'code' => 'imax_id',
                'name' => 'IMAX Laser Premiere',
                'currency_code' => 'IDR',
                'base_price' => 95000.00,
            ],
            [
                'code' => 'vip_id',
                'name' => 'Velvet Lounge VIP',
                'currency_code' => 'IDR',
                'base_price' => 125000.00,
            ],
            [
                'code' => 'matinee_us',
                'name' => 'Historic Matinee (USD)',
                'currency_code' => 'USD',
                'base_price' => 9.50,
            ],
            [
                'code' => 'evening_us',
                'name' => 'Evening Archival Feature (USD)',
                'currency_code' => 'USD',
                'base_price' => 14.00,
            ],
        ];

        foreach ($tiers as $t) {
            PricingTier::updateOrCreate(['code' => $t['code']], $t);
        }
    }
}
