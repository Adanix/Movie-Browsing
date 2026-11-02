<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Cinema;
use App\Models\Auditorium;
use App\Models\Movie;
use App\Models\PricingTier;
use App\Services\Schedule\ShowtimeConflictValidator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShowtimeManagementController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Showtime::with(['movie', 'cinema.city', 'auditorium', 'pricingTier'])
            ->where('starts_at', '>=', now()->subHours(6))
            ->orderBy('starts_at');

        if ($user->role === 'cinema_manager') {
            $query->whereHas('cinema.city', fn($q) => $q->whereIn('slug', ['jakarta', 'bandung']));
        }

        if ($request->filled('cinema_id')) {
            $query->where('cinema_id', $request->query('cinema_id'));
        }

        if ($request->filled('date')) {
            $query->whereDate('screening_date', $request->query('date'));
        }

        $showtimes = $query->paginate(15);

        $cinemasQuery = Cinema::with('city')->where('is_active', true);
        if ($user->role === 'cinema_manager') {
            $cinemasQuery->whereHas('city', fn($q) => $q->whereIn('slug', ['jakarta', 'bandung']));
        }
        $cinemas = $cinemasQuery->get();

        $movies = Movie::where('release_status', 'now_showing')->get();
        $pricingTiers = PricingTier::all();

        return view('manage.showtimes.index', compact('showtimes', 'cinemas', 'movies', 'pricingTiers'));
    }

    public function store(Request $request, ShowtimeConflictValidator $conflictValidator): RedirectResponse
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'cinema_id' => 'required|exists:cinemas,id',
            'auditorium_id' => 'required|exists:auditoriums,id',
            'pricing_tier_id' => 'required|exists:pricing_tiers,id',
            'screening_date' => 'required|date',
            'start_time' => 'required|string', // e.g. 19:30
            'presentation_format' => 'required|string|max:60',
            'is_captioned_cc' => 'boolean',
            'is_audio_described_ad' => 'boolean',
            'is_sensory_friendly_sf' => 'boolean',
            'is_parent_baby_pb' => 'boolean',
        ]);

        $cinema = Cinema::with('city')->findOrFail($validated['cinema_id']);
        $this->authorize('create', [Showtime::class, $cinema]);

        $movie = Movie::findOrFail($validated['movie_id']);
        $auditorium = Auditorium::findOrFail($validated['auditorium_id']);

        $startsAt = Carbon::parse("{$validated['screening_date']} {$validated['start_time']}");
        $endsAt = $startsAt->copy()->addMinutes($movie->runtime_minutes + 20); // 20m turnaround

        // Check for double-booking / overlap conflict!
        $conflict = $conflictValidator->findConflict($auditorium->id, $startsAt, $endsAt);

        if ($conflict) {
            $conflictingMovie = $conflict->movie->title ?? 'Scheduled screening';
            $conflictWindow = $conflict->starts_at->format('H:i') . ' – ' . $conflict->ends_at->format('H:i');

            return back()->withInput()->withErrors([
                'start_time' => "Schedule conflict in {$auditorium->name}: overlaps with '{$conflictingMovie}' ({$conflictWindow}). Please select a different time or auditorium.",
            ]);
        }

        Showtime::create([
            'movie_id' => $movie->id,
            'cinema_id' => $cinema->id,
            'auditorium_id' => $auditorium->id,
            'pricing_tier_id' => $validated['pricing_tier_id'],
            'screening_date' => $validated['screening_date'],
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'presentation_format' => $validated['presentation_format'],
            'audio_language_code' => $movie->audio_language_code,
            'subtitle_language_code' => $movie->subtitle_languages_json[0] ?? 'id',
            'is_captioned_cc' => $request->boolean('is_captioned_cc'),
            'is_audio_described_ad' => $request->boolean('is_audio_described_ad'),
            'is_sensory_friendly_sf' => $request->boolean('is_sensory_friendly_sf'),
            'is_parent_baby_pb' => $request->boolean('is_parent_baby_pb'),
            'available_seats_estimate' => $auditorium->total_capacity,
            'status' => 'scheduled',
        ]);

        return redirect()->route('manage.showtimes.index')->with('status_toast', [
            'type' => 'success',
            'title' => 'Showtime Added',
            'message' => "Screening for '{$movie->title}' at {$cinema->name} scheduled.",
        ]);
    }

    public function destroy(Showtime $showtime): RedirectResponse
    {
        $this->authorize('delete', $showtime);

        $showtime->delete();

        return redirect()->route('manage.showtimes.index')->with('status_toast', [
            'type' => 'info',
            'title' => 'Screening Cancelled',
            'message' => 'Showtime has been removed from the schedule.',
        ]);
    }
}
