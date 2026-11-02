<?php

namespace App\Services\Schedule;

use App\Models\Showtime;
use Carbon\Carbon;

class ShowtimeConflictValidator
{
    /**
     * Check if a proposed showtime in an auditorium conflicts with an existing screening.
     */
    public function findConflict(
        int $auditoriumId,
        Carbon|string $startsAt,
        Carbon|string $endsAt,
        ?int $ignoreShowtimeId = null
    ): ?Showtime {
        $start = Carbon::parse($startsAt);
        $end = Carbon::parse($endsAt);

        $query = Showtime::query()
            ->with(['movie', 'auditorium.cinema'])
            ->where('auditorium_id', $auditoriumId)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($start, $end) {
                $q->where('starts_at', '<', $end)
                  ->where('ends_at', '>', $start);
            });

        if ($ignoreShowtimeId) {
            $query->where('id', '!=', $ignoreShowtimeId);
        }

        return $query->first();
    }
}
