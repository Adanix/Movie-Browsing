<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Watchlist;
use App\Models\ReleaseReminder;
use App\Models\SimulatedNotificationLog;
use App\Contracts\NotificationProviderInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class WatchlistController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $activeCity = view()->shared('activeCity');

        if ($user) {
            $watchlistItems = Watchlist::with(['movie.genres', 'movie.audioLanguage', 'movie.primaryTrailer'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            $releaseReminders = ReleaseReminder::with(['movie.genres', 'city'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            $notificationLogs = SimulatedNotificationLog::with(['movie', 'city'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(10)
                ->get();
        } else {
            $guestIds = $request->session()->get('guest_watchlist', []);
            $watchlistItems = Movie::with(['genres', 'audioLanguage', 'primaryTrailer'])
                ->whereIn('id', $guestIds)
                ->get()
                ->map(fn($m) => (object) ['movie' => $m, 'notes' => 'Guest Session Bookmark', 'created_at' => now()]);

            $releaseReminders = collect();
            $notificationLogs = collect();
        }

        return view('watchlist.index', compact('watchlistItems', 'releaseReminders', 'notificationLogs'));
    }

    public function toggle(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'movie_id' => 'required|integer|exists:movies,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $movieId = (int) $validated['movie_id'];
        $user = $request->user();
        $isAdded = false;

        if ($user) {
            $existing = Watchlist::where('user_id', $user->id)->where('movie_id', $movieId)->first();
            if ($existing) {
                $existing->delete();
                $isAdded = false;
            } else {
                Watchlist::create([
                    'user_id' => $user->id,
                    'movie_id' => $movieId,
                    'notes' => $validated['notes'] ?? 'Added from catalog',
                ]);
                $isAdded = true;
            }
            $totalCount = Watchlist::where('user_id', $user->id)->count();
        } else {
            $list = $request->session()->get('guest_watchlist', []);
            if (in_array($movieId, $list)) {
                $list = array_values(array_diff($list, [$movieId]));
                $isAdded = false;
            } else {
                $list[] = $movieId;
                $isAdded = true;
            }
            $request->session()->put('guest_watchlist', $list);
            $totalCount = count($list);
        }

        $message = $isAdded ? 'Film added to your Watchlist.' : 'Film removed from your Watchlist.';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_added' => $isAdded,
                'count' => $totalCount,
                'message' => $message,
            ]);
        }

        return back()->with('status_toast', [
            'type' => 'success',
            'title' => $isAdded ? 'Watchlist Updated' : 'Removed',
            'message' => $message,
        ]);
    }

    public function storeReminder(Movie $movie, Request $request, NotificationProviderInterface $notifier): RedirectResponse
    {
        $user = $request->user();
        $activeCity = view()->shared('activeCity');

        if (!$activeCity) {
            return back()->with('status_toast', [
                'type' => 'error',
                'title' => 'City Required',
                'message' => 'Please select a city to set release reminders.',
            ]);
        }

        $existing = ReleaseReminder::where('user_id', $user->id)
            ->where('movie_id', $movie->id)
            ->where('city_id', $activeCity->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('status_toast', [
                'type' => 'info',
                'title' => 'Alert Unsubscribed',
                'message' => "Opening-night reminder for {$movie->title} removed.",
            ]);
        }

        ReleaseReminder::create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'city_id' => $activeCity->id,
            'status' => 'subscribed',
        ]);

        $notifier->dispatchReleaseReminder($user, $movie, $activeCity);

        return back()->with('status_toast', [
            'type' => 'success',
            'title' => 'Reminder Subscribed',
            'message' => "You will receive an alert when {$movie->title} premieres in {$activeCity->name}.",
        ]);
    }
}
