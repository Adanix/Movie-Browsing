<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\PricingTier;
use App\Models\Showtime;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();
        $cinemas = Cinema::with('auditoriums', 'city')->get();
        $nowShowingMovies = Movie::where('release_status', 'now_showing')->get();
        $pricingTiers = PricingTier::all()->keyBy('code');

        if ($cinemas->isEmpty() || $nowShowingMovies->isEmpty()) {
            return;
        }

        // Daily standard time slots (hour, minute)
        $timeSlots = [
            ['11', '30'],
            ['14', '15'],
            ['17', '00'],
            ['19', '45'],
            ['22', '15'],
        ];

        $movieIndex = 0;
        $totalMovies = $nowShowingMovies->count();

        // 14 days rolling window
        for ($day = 0; $day < 14; $day++) {
            $screeningDate = $today->copy()->addDays($day);

            foreach ($cinemas as $cinema) {
                $isUs = ($cinema->city->currency_code === 'USD');

                foreach ($cinema->auditoriums as $audIndex => $auditorium) {
                    // Pick 2-3 time slots per auditorium per day
                    $activeSlots = ($audIndex % 2 === 0)
                        ? [$timeSlots[0], $timeSlots[2], $timeSlots[3]]
                        : [$timeSlots[1], $timeSlots[3], $timeSlots[4]];

                    foreach ($activeSlots as $slotIdx => $slot) {
                        $movie = $nowShowingMovies[$movieIndex % $totalMovies];
                        $movieIndex++;

                        $startsAt = $screeningDate->copy()->setTime((int)$slot[0], (int)$slot[1], 0);
                        $endsAt = $startsAt->copy()->addMinutes($movie->runtime_minutes + 20);

                        // Determine pricing tier
                        $isMatinee = (int)$slot[0] < 17;
                        if ($isUs) {
                            $tier = $isMatinee ? ($pricingTiers['matinee_us'] ?? null) : ($pricingTiers['evening_us'] ?? null);
                        } else {
                            if (str_contains($auditorium->screen_format, 'IMAX')) {
                                $tier = $pricingTiers['imax_id'] ?? null;
                            } elseif (str_contains($auditorium->screen_format, 'VIP') || str_contains($auditorium->screen_format, 'Recliner')) {
                                $tier = $pricingTiers['vip_id'] ?? null;
                            } elseif ($isMatinee) {
                                $tier = $pricingTiers['matinee_id'] ?? null;
                            } else {
                                $tier = $pricingTiers['evening_id'] ?? null;
                            }
                        }

                        // Determine accessibility flags
                        $isCc = ($slotIdx === 0 || $slotIdx === 2);
                        $isAd = ($slotIdx === 1);
                        $isSf = ($isMatinee && $audIndex === 1);
                        $isPb = ($isMatinee && $slotIdx === 0 && $day === 2);

                        // Status variation
                        $status = 'scheduled';
                        $seatsEstimate = $auditorium->total_capacity - rand(10, 45);
                        if ($day === 0 && $slotIdx === 2) {
                            $status = 'selling_fast';
                            $seatsEstimate = rand(12, 28);
                        }

                        Showtime::create([
                            'movie_id' => $movie->id,
                            'cinema_id' => $cinema->id,
                            'auditorium_id' => $auditorium->id,
                            'pricing_tier_id' => $tier?->id,
                            'screening_date' => $screeningDate->toDateString(),
                            'starts_at' => $startsAt,
                            'ends_at' => $endsAt,
                            'presentation_format' => $auditorium->screen_format,
                            'audio_language_code' => $movie->audio_language_code,
                            'subtitle_language_code' => ($movie->subtitle_languages_json[0] ?? 'id'),
                            'is_captioned_cc' => $isCc,
                            'is_audio_described_ad' => $isAd,
                            'is_sensory_friendly_sf' => $isSf,
                            'is_parent_baby_pb' => $isPb,
                            'available_seats_estimate' => max(5, $seatsEstimate),
                            'status' => $status,
                        ]);
                    }
                }
            }
        }
    }
}
