<?php

namespace App\Contracts;

use App\Models\User;
use App\Models\Movie;
use App\Models\City;

interface NotificationProviderInterface
{
    /**
     * Dispatch simulated release reminder alert.
     */
    public function dispatchReleaseReminder(User $user, Movie $movie, City $city): array;
}
