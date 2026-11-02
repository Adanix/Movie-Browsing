<?php

namespace App\Contracts;

use App\Models\City;
use Illuminate\Support\Collection;

interface GeolocationProviderInterface
{
    /**
     * Resolve nearest city and calculate distance for cinemas.
     */
    public function resolveNearestCity(float $latitude, float $longitude): ?City;

    /**
     * Calculate Haversine distance in kilometers between two coordinates.
     */
    public function calculateDistanceKm(float $lat1, float $lon1, float $lat2, float $lon2): float;
}
