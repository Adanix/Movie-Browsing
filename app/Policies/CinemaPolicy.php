<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cinema;

class CinemaPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Cinema $cinema): bool
    {
        return true;
    }

    public function update(User $user, Cinema $cinema): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            // Marcus Sterling is assigned to Jakarta & Bandung
            $allowedCities = ['jakarta', 'bandung'];
            return in_array($cinema->city->slug ?? '', $allowedCities);
        }

        return false;
    }
}
