<?php

namespace App\Services\Ticketing;

use App\Contracts\TicketingSlotInterface;
use App\Models\Showtime;
use App\DataTransferObjects\ShowtimeSlotContext;

class PhaseOnePreviewSlotAdapter implements TicketingSlotInterface
{
    public function prepareSlotContext(Showtime $showtime): ShowtimeSlotContext
    {
        $showtime->loadMissing([
            'movie.genres',
            'cinema.city',
            'auditorium',
            'pricingTier',
        ]);

        $pricing = $showtime->pricingTier;
        $formattedPrice = $pricing ? $pricing->formattedPrice() : 'IDR 65.000';
        $basePrice = $pricing ? (float) $pricing->base_price : 65000.00;
        $currency = $pricing ? $pricing->currency_code : ($showtime->cinema->city->currency_code ?? 'IDR');

        return new ShowtimeSlotContext(
            showtimeId: $showtime->id,
            movieId: $showtime->movie_id,
            movieTitle: $showtime->movie->title,
            movieSlug: $showtime->movie->slug,
            moviePosterUrl: $showtime->movie->poster_image_url,
            cinemaId: $showtime->cinema_id,
            cinemaName: $showtime->cinema->name,
            cinemaSlug: $showtime->cinema->slug,
            cityName: $showtime->cinema->city->name ?? 'Jakarta',
            auditoriumId: $showtime->auditorium_id,
            auditoriumName: $showtime->auditorium->name,
            screenFormat: $showtime->presentation_format ?: $showtime->auditorium->screen_format,
            soundSystem: $showtime->auditorium->sound_system,
            totalCapacity: $showtime->auditorium->total_capacity,
            screeningDate: $showtime->screening_date->format('l, d M Y'),
            startsAt: $showtime->starts_at->format('H:i'),
            endsAt: $showtime->ends_at ? $showtime->ends_at->format('H:i') : '',
            formattedPrice: $formattedPrice,
            basePrice: $basePrice,
            currencyCode: $currency,
            availableSeatsCount: $showtime->available_seats_estimate,
            accessibilityBadges: $showtime->accessibilityBadges(),
        );
    }

    public function isSlotAvailable(Showtime $showtime): bool
    {
        return $showtime->status !== 'cancelled' && $showtime->status !== 'sold_out';
    }
}
