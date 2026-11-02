<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\City;
use App\Models\Showtime;
use App\Contracts\GeolocationProviderInterface;
use App\Services\Simulators\SimulatedGeolocationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CinemaDirectoryController extends Controller
{
    public function index(Request $request, GeolocationProviderInterface $geo): View
    {
        $activeCity = view()->shared('activeCity');
        $allCities = view()->shared('allCities');
        $showAllCities = $request->boolean('all_cities', false);

        $query = Cinema::query()->with(['city', 'auditoriums'])->where('is_active', true);

        if (!$showAllCities && $activeCity) {
            $query->where('city_id', $activeCity->id);
        }

        // Format filter (IMAX, 35mm, Atmos)
        if ($request->filled('format')) {
            $format = $request->query('format');
            $query->whereHas('auditoriums', fn($q) => $q->where('screen_format', 'like', "%{$format}%"));
        }

        $userCoords = $request->session()->get('user_coords');
        $refCity = $activeCity ?? $allCities->first();

        $cinemas = $query->get()->map(function ($cinema) use ($geo, $userCoords, $refCity) {
            $refLat = $userCoords['lat'] ?? (float) ($cinema->city->center_latitude ?? $refCity->center_latitude);
            $refLon = $userCoords['lng'] ?? (float) ($cinema->city->center_longitude ?? $refCity->center_longitude);
            $cinema->calculated_distance_km = $geo->calculateDistanceKm($refLat, $refLon, $cinema->latitude, $cinema->longitude);

            // Count today's screenings
            $cinema->today_screenings_count = Showtime::where('cinema_id', $cinema->id)
                ->whereDate('screening_date', Carbon::today())
                ->where('status', '!=', 'cancelled')
                ->count();

            return $cinema;
        })->sortBy('calculated_distance_km')->values();

        $presets = SimulatedGeolocationService::PRESETS;

        return view('cinemas.index', compact('cinemas', 'showAllCities', 'presets', 'userCoords'));
    }

    public function show(Cinema $cinema, Request $request): View
    {
        $cinema->load(['city', 'auditoriums']);

        $selectedDate = $request->query('date', Carbon::today()->toDateString());
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)) {
            $selectedDate = Carbon::today()->toDateString();
        }

        // 14-day rolling date tabs
        $dateTabs = [];
        for ($i = 0; $i < 14; $i++) {
            $d = Carbon::today()->addDays($i);
            $dateTabs[] = [
                'date' => $d->toDateString(),
                'day_name' => $i === 0 ? 'Today' : ($i === 1 ? 'Tomorrow' : $d->format('D')),
                'day_num' => $d->format('d M'),
                'is_selected' => ($d->toDateString() === $selectedDate),
            ];
        }

        // Movies and showtimes playing in this cinema on the selected date
        $showtimes = Showtime::query()
            ->with(['movie.genres', 'auditorium', 'pricingTier'])
            ->where('cinema_id', $cinema->id)
            ->whereDate('screening_date', $selectedDate)
            ->where('status', '!=', 'cancelled')
            ->orderBy('starts_at')
            ->get();

        // Group by movie
        $moviesPlaying = collect();
        foreach ($showtimes->groupBy('movie_id') as $movieId => $movieShowtimes) {
            $movie = $movieShowtimes->first()->movie;
            $movie->day_showtimes = $movieShowtimes;
            $moviesPlaying->push($movie);
        }

        return view('cinemas.show', compact('cinema', 'dateTabs', 'selectedDate', 'moviesPlaying'));
    }
}
