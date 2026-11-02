<?php

namespace App\DataTransferObjects;

class ShowtimeSlotContext
{
    public function __construct(
        public readonly int $showtimeId,
        public readonly int $movieId,
        public readonly string $movieTitle,
        public readonly string $movieSlug,
        public readonly ?string $moviePosterUrl,
        public readonly int $cinemaId,
        public readonly string $cinemaName,
        public readonly string $cinemaSlug,
        public readonly string $cityName,
        public readonly int $auditoriumId,
        public readonly string $auditoriumName,
        public readonly string $screenFormat,
        public readonly string $soundSystem,
        public readonly int $totalCapacity,
        public readonly string $screeningDate,
        public readonly string $startsAt,
        public readonly string $endsAt,
        public readonly string $formattedPrice,
        public readonly float $basePrice,
        public readonly string $currencyCode,
        public readonly int $availableSeatsCount,
        public readonly array $accessibilityBadges,
        public readonly string $readinessStatus = 'PHASE_2_SLOT_IN_READY',
        public readonly array $slotInContractMeta = [
            'contract' => 'App\Contracts\TicketingSlotInterface',
            'phase' => 'Milestone 1 Demo (Browsing & Slot-In Preview)',
            'next_phase_modules' => [
                'SeatMapReservationService (Redis TTL Lock)',
                'PaymentCheckoutGateway (Stripe / Midtrans)',
                'ETicketBarcodeGenerator',
            ],
        ],
    ) {}

    public function toArray(): array
    {
        return [
            'showtime_id' => $this->showtimeId,
            'movie' => [
                'id' => $this->movieId,
                'title' => $this->movieTitle,
                'slug' => $this->movieSlug,
                'poster_url' => $this->moviePosterUrl,
            ],
            'cinema' => [
                'id' => $this->cinemaId,
                'name' => $this->cinemaName,
                'slug' => $this->cinemaSlug,
                'city' => $this->cityName,
            ],
            'auditorium' => [
                'id' => $this->auditoriumId,
                'name' => $this->auditoriumName,
                'format' => $this->screenFormat,
                'sound' => $this->soundSystem,
                'capacity' => $this->totalCapacity,
            ],
            'schedule' => [
                'date' => $this->screeningDate,
                'starts_at' => $this->startsAt,
                'ends_at' => $this->endsAt,
            ],
            'pricing' => [
                'formatted' => $this->formattedPrice,
                'amount' => $this->basePrice,
                'currency' => $this->currencyCode,
            ],
            'seats' => [
                'available_estimate' => $this->availableSeatsCount,
            ],
            'accessibility' => $this->accessibilityBadges,
            'readiness' => $this->readinessStatus,
            'meta' => $this->slotInContractMeta,
        ];
    }
}
