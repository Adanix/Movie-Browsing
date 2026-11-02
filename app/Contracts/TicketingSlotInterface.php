<?php

namespace App\Contracts;

use App\Models\Showtime;
use App\DataTransferObjects\ShowtimeSlotContext;

interface TicketingSlotInterface
{
    /**
     * Prepare verified showtime slot context for the Phase 2 boundary.
     */
    public function prepareSlotContext(Showtime $showtime): ShowtimeSlotContext;

    /**
     * Check if the showtime is valid and eligible for slot-in booking.
     */
    public function isSlotAvailable(Showtime $showtime): bool;
}
