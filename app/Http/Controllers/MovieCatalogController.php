<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Showtime;
use App\Models\Cinema;
use App\Services\Catalog\MovieCatalogQueryService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieCatalogController extends Controller
{
    public function index(Request $request, MovieCatalogQueryService $catalogService): View
    {
        $activeCity = view()->shared('activeCity');
        $cityId = $activeCity?->id;

        $filters = $request->only([
            'q',
            'genre',
            'language',
            'subtitle',
            'release_status',
            'release_window',
            'release_from',
            'release_to',
            'screening_date',
            'accessibility',
            'sort',
            'view',
        ]);

        $movies = $catalogService->query($filters, $cityId, 12);
        $genres = Genre::all();
        $languages = Language::all();

        // Counts for tabs
        $totalNowShowing = Movie::where('release_status', 'now_showing')->count();
        $totalComingSoon = Movie::where('release_status', 'coming_soon')->count();

        // Active layout mode (bento, grid, timeline)
        $currentView = $request->query('view', 'bento');
        if (!in_array($currentView, ['bento', 'grid', 'timeline'])) {
            $currentView = 'bento';
        }

        return view('movies.index', compact(
            'movies',
            'genres',
            'languages',
            'filters',
            'totalNowShowing',
            'totalComingSoon',
            'currentView'
        ));
    }

    public function show(Movie $movie, Request $request): View
    {
        $movie->load([
            'genres',
            'audioLanguage',
            'trailers',
            'primaryTrailer',
            'credits',
        ]);

        $activeCity = view()->shared('activeCity');
        $cityId = $activeCity?->id;

        // Selected date tab (defaults to today)
        $selectedDate = $request->query('date', Carbon::today()->toDateString());
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)) {
            $selectedDate = Carbon::today()->toDateString();
        }

        // 14-day rolling date ribbon
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

        // Showtimes grouped by Cinema in active city on selected date
        $cinemasWithShowtimes = collect();
        if ($cityId) {
            $cinemas = Cinema::where('city_id', $cityId)
                ->where('is_active', true)
                ->with(['auditoriums'])
                ->get();

            $showtimes = Showtime::query()
                ->with(['auditorium', 'pricingTier'])
                ->where('movie_id', $movie->id)
                ->whereHas('cinema', fn($q) => $q->where('city_id', $cityId))
                ->whereDate('screening_date', $selectedDate)
                ->where('status', '!=', 'cancelled')
                ->orderBy('starts_at')
                ->get();

            foreach ($cinemas as $c) {
                $cShowtimes = $showtimes->where('cinema_id', $c->id)->values();
                if ($cShowtimes->isNotEmpty()) {
                    $c->date_showtimes = $cShowtimes;
                    $cinemasWithShowtimes->push($c);
                }
            }
        }

        // Check if bookmarked in watchlist
        $isWatchlisted = false;
        if (auth()->check()) {
            $isWatchlisted = auth()->user()->watchlists()->where('movie_id', $movie->id)->exists();
        } else {
            $guestWatchlist = session('guest_watchlist', []);
            $isWatchlisted = in_array($movie->id, $guestWatchlist);
        }

        // Check if subscribed to release reminder
        $isReminderSet = false;
        if (auth()->check() && $cityId) {
            $isReminderSet = auth()->user()->releaseReminders()
                ->where('movie_id', $movie->id)
                ->where('city_id', $cityId)
                ->exists();
        }

        return view('movies.show', compact(
            'movie',
            'dateTabs',
            'selectedDate',
            'cinemasWithShowtimes',
            'isWatchlisted',
            'isReminderSet'
        ));
    }
}
