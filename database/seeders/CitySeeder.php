<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Jakarta',
                'slug' => 'jakarta',
                'province_or_state' => 'DKI Jakarta',
                'country_code' => 'ID',
                'currency_code' => 'IDR',
                'timezone' => 'Asia/Jakarta',
                'center_latitude' => -6.2087634,
                'center_longitude' => 106.8455990,
                'tagline' => 'The Metropole Circuit · Grand Palaces & Laser IMAX',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Bandung',
                'slug' => 'bandung',
                'province_or_state' => 'Jawa Barat',
                'country_code' => 'ID',
                'currency_code' => 'IDR',
                'timezone' => 'Asia/Jakarta',
                'center_latitude' => -6.9174640,
                'center_longitude' => 107.6191230,
                'tagline' => 'Paris van Java · Art-Deco Heritage Screenings',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Surabaya',
                'slug' => 'surabaya',
                'province_or_state' => 'Jawa Timur',
                'country_code' => 'ID',
                'currency_code' => 'IDR',
                'timezone' => 'Asia/Jakarta',
                'center_latitude' => -7.2574719,
                'center_longitude' => 112.7520883,
                'tagline' => 'Heroes & Film Noir · Tunjungan Multiplexes',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Bali (Denpasar)',
                'slug' => 'bali',
                'province_or_state' => 'Bali',
                'country_code' => 'ID',
                'currency_code' => 'IDR',
                'timezone' => 'Asia/Makassar',
                'center_latitude' => -8.6704582,
                'center_longitude' => 115.2126293,
                'tagline' => 'Island Cinema · Sunset Velvet Lounges & Festivals',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Missoula (Heritage Flagship)',
                'slug' => 'missoula',
                'province_or_state' => 'Montana',
                'country_code' => 'US',
                'currency_code' => 'USD',
                'timezone' => 'America/Denver',
                'center_latitude' => 46.8721500,
                'center_longitude' => -113.9940190,
                'tagline' => 'The 1931 Garnet Theater · Archival 35mm Vault',
                'is_featured' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($cities as $c) {
            City::updateOrCreate(['slug' => $c['slug']], $c);
        }
    }
}
