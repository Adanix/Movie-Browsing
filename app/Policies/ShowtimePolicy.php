<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Showtime;
use App\Models\Cinema;

class ShowtimePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function create(User $user, ?Cinema $cinema = null): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            if ($cinema) {
                return in_array($cinema->city->slug ?? '', ['jakarta', 'bandung']);
            }
            return true;
        }

        return false;
    }

    public function delete(User $user, Showtime $showtime): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isManager()) {
            return in_array($showtime->cinema->city->slug ?? '', ['jakarta', 'bandung']);
        }

        return false;
    }
}
