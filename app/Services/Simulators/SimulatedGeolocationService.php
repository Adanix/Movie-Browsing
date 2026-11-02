<?php

namespace App\Services\Simulators;

use App\Contracts\GeolocationProviderInterface;
use App\Models\City;

class SimulatedGeolocationService implements GeolocationProviderInterface
{
    public const PRESETS = [
        'jakarta_south' => [
            'name' => 'Jakarta Selatan (Senayan / Blok M)',
            'lat' => -6.225014,
            'lng' => 106.802872,
            'target_city' => 'jakarta',
        ],
        'bandung_center' => [
            'name' => 'Bandung Pusat (Braga / Asia Afrika)',
            'lat' => -6.917464,
            'lng' => 107.619123,
            'target_city' => 'bandung',
        ],
        'surabaya_east' => [
            'name' => 'Surabaya Pusat (Tunjungan)',
            'lat' => -7.261882,
            'lng' => 112.741875,
            'target_city' => 'surabaya',
        ],
        'bali_seminyak' => [
            'name' => 'Bali (Seminyak / Sunset Road)',
            'lat' => -8.691307,
            'lng' => 115.168228,
            'target_city' => 'bali',
        ],
        'missoula_mt' => [
            'name' => 'Missoula MT (Historic Garnet District)',
            'lat' => 46.872150,
            'lng' => -113.994019,
            'target_city' => 'missoula',
        ],
    ];

    public function resolveNearestCity(float $latitude, float $longitude): ?City
    {
        $cities = City::all();
        if ($cities->isEmpty()) {
            return null;
        }

        $nearest = null;
        $minDistance = PHP_FLOAT_MAX;

        foreach ($cities as $city) {
            $dist = $this->calculateDistanceKm($latitude, $longitude, (float) $city->center_latitude, (float) $city->center_longitude);
            if ($dist < $minDistance) {
                $minDistance = $dist;
                $nearest = $city;
            }
        }

        return $nearest;
    }

    public function calculateDistanceKm(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 1);
    }
}
