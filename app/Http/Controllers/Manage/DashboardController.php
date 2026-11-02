<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\City;
use App\Models\Showtime;
use App\Models\Watchlist;
use App\Models\ExternalSyncLog;
use App\Models\DemoActivityLog;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $metrics = [
            'total_movies' => Movie::count(),
            'now_showing' => Movie::where('release_status', 'now_showing')->count(),
            'coming_soon' => Movie::where('release_status', 'coming_soon')->count(),
            'total_cinemas' => Cinema::count(),
            'total_cities' => City::count(),
            'active_showtimes' => Showtime::where('starts_at', '>=', now())->where('status', '!=', 'cancelled')->count(),
            'total_watchlists' => Watchlist::count(),
        ];

        $recentSyncs = ExternalSyncLog::latest()->take(5)->get();
        $recentLogs = DemoActivityLog::with('user')->latest()->take(8)->get();

        return view('manage.dashboard', compact('metrics', 'recentSyncs', 'recentLogs'));
    }
}
