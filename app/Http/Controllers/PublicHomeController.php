<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Cinema;
use App\Models\Showtime;
use App\Contracts\GeolocationProviderInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicHomeController extends Controller
{
    public function index(Request $request, GeolocationProviderInterface $geo): View
    {
        $activeCity = view()->shared('activeCity');
        $cityId = $activeCity?->id;

        // 1. Featured Hero Carousel Movies
        $featuredMovies = Movie::query()
            ->with(['genres', 'audioLanguage', 'primaryTrailer'])
            ->where('is_featured', true)
            ->orderBy('featured_sort_order')
            ->take(3)
            ->get();

        if ($featuredMovies->isEmpty()) {
            $featuredMovies = Movie::query()->with(['genres', 'audioLanguage', 'primaryTrailer'])->take(3)->get();
        }

        // 2. Next Screening in Active City for Live Marquee Countdown
        $nextScreening = null;
        if ($cityId) {
            $nextScreening = Showtime::query()
                ->with(['movie', 'cinema', 'auditorium'])
                ->whereHas('cinema', fn($q) => $q->where('city_id', $cityId))
                ->where('starts_at', '>=', now())
                ->where('status', '!=', 'cancelled')
                ->orderBy('starts_at')
                ->first();
        }

        // 3. Showcase Catalog Titles (for Animated Section on Homepage)
        $trendingMovies = Movie::query()
            ->with(['genres', 'audioLanguage', 'primaryTrailer'])
            ->where('is_trending', true)
            ->take(8)
            ->get();

        $nowShowingMovies = Movie::query()
            ->with(['genres', 'audioLanguage', 'primaryTrailer'])
            ->where('release_status', 'now_showing')
            ->take(8)
            ->get();

        $comingSoonMovies = Movie::query()
            ->with(['genres', 'audioLanguage', 'primaryTrailer'])
            ->where('release_status', 'coming_soon')
            ->take(6)
            ->get();

        // 4. Nearby Cinemas in Active City with Distance Calculation
        $userCoords = $request->session()->get('user_coords');
        $cinemas = collect();
        if ($cityId) {
            $cinemas = Cinema::query()
                ->with(['auditoriums'])
                ->where('city_id', $cityId)
                ->where('is_active', true)
                ->get()
                ->map(function ($cinema) use ($geo, $userCoords, $activeCity) {
                    $refLat = $userCoords['lat'] ?? (float) $activeCity->center_latitude;
                    $refLon = $userCoords['lng'] ?? (float) $activeCity->center_longitude;
                    $cinema->calculated_distance_km = $geo->calculateDistanceKm($refLat, $refLon, $cinema->latitude, $cinema->longitude);
                    return $cinema;
                })
                ->sortBy('calculated_distance_km')
                ->values();
        }

        $genres = Genre::all();
        $languages = Language::all();

        return view('public.home', compact(
            'featuredMovies',
            'nextScreening',
            'trendingMovies',
            'nowShowingMovies',
            'comingSoonMovies',
            'cinemas',
            'genres',
            'languages'
        ));
    }
}
