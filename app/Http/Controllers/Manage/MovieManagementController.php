<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class MovieManagementController extends Controller
{
    public function index(): View
    {
        $movies = Movie::with(['genres', 'audioLanguage'])->latest()->paginate(15);
        return view('manage.movies.index', compact('movies'));
    }

    public function create(): View
    {
        $genres = Genre::all();
        $languages = Language::all();
        return view('manage.movies.create', compact('genres', 'languages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:180',
            'original_title' => 'nullable|string|max:180',
            'tagline' => 'nullable|string|max:255',
            'synopsis' => 'required|string',
            'release_status' => 'required|in:now_showing,coming_soon,archived',
            'release_date' => 'required|date',
            'runtime_minutes' => 'required|integer|min:30|max:360',
            'age_rating' => 'required|string|max:20',
            'audio_language_code' => 'required|string|exists:languages,code',
            'subtitle_languages' => 'nullable|array',
            'director_name' => 'nullable|string|max:140',
            'studio_name' => 'nullable|string|max:140',
            'aspect_ratio' => 'nullable|string|max:30',
            'audience_score' => 'nullable|numeric|min:0|max:10',
            'critic_score' => 'nullable|integer|min:0|max:100',
            'poster_image_url' => 'nullable|url|max:255',
            'backdrop_image_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'is_trending' => 'boolean',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
            'trailer_title' => 'nullable|string|max:150',
            'video_stream_url' => 'nullable|url|max:255',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Movie::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $movie = Movie::create([
            'title' => $validated['title'],
            'original_title' => $validated['original_title'],
            'slug' => $slug,
            'tagline' => $validated['tagline'],
            'synopsis' => $validated['synopsis'],
            'release_status' => $validated['release_status'],
            'release_date' => $validated['release_date'],
            'runtime_minutes' => $validated['runtime_minutes'],
            'age_rating' => $validated['age_rating'],
            'audio_language_code' => $validated['audio_language_code'],
            'subtitle_languages_json' => $validated['subtitle_languages'] ?? ['en', 'id'],
            'director_name' => $validated['director_name'],
            'studio_name' => $validated['studio_name'] ?? 'Matinee Studios',
            'aspect_ratio' => $validated['aspect_ratio'] ?? '2.39:1 Scope',
            'audience_score' => $validated['audience_score'] ?? 8.5,
            'critic_score' => $validated['critic_score'] ?? 90,
            'poster_image_url' => $validated['poster_image_url'],
            'backdrop_image_url' => $validated['backdrop_image_url'],
            'is_featured' => $request->boolean('is_featured'),
            'is_trending' => $request->boolean('is_trending'),
            'poster_palette_json' => ['bg' => '#141118', 'accent' => '#F5C518', 'secondary' => '#E11D48', 'motif' => 'deco_sunburst', 'icon' => 'sparkles'],
        ]);

        if (!empty($validated['genres'])) {
            $movie->genres()->sync($validated['genres']);
        }

        if (!empty($validated['video_stream_url'])) {
            $movie->trailers()->create([
                'title' => $validated['trailer_title'] ?? 'Official Theatrical Trailer',
                'trailer_type' => 'official_trailer',
                'duration_seconds' => 125,
                'video_stream_url' => $validated['video_stream_url'],
                'is_primary' => true,
            ]);
        }

        return redirect()->route('manage.movies.index')->with('status_toast', [
            'type' => 'success',
            'title' => 'Film Added',
            'message' => "Movie '{$movie->title}' added to catalog.",
        ]);
    }

    public function edit(Movie $movie): View
    {
        $movie->load(['genres', 'primaryTrailer']);
        $genres = Genre::all();
        $languages = Language::all();
        return view('manage.movies.edit', compact('movie', 'genres', 'languages'));
    }

    public function update(Request $request, Movie $movie): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:180',
            'original_title' => 'nullable|string|max:180',
            'tagline' => 'nullable|string|max:255',
            'synopsis' => 'required|string',
            'release_status' => 'required|in:now_showing,coming_soon,archived',
            'release_date' => 'required|date',
            'runtime_minutes' => 'required|integer|min:30|max:360',
            'age_rating' => 'required|string|max:20',
            'audio_language_code' => 'required|string|exists:languages,code',
            'subtitle_languages' => 'nullable|array',
            'director_name' => 'nullable|string|max:140',
            'studio_name' => 'nullable|string|max:140',
            'aspect_ratio' => 'nullable|string|max:30',
            'audience_score' => 'nullable|numeric|min:0|max:10',
            'critic_score' => 'nullable|integer|min:0|max:100',
            'poster_image_url' => 'nullable|url|max:255',
            'backdrop_image_url' => 'nullable|url|max:255',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $movie->update([
            'title' => $validated['title'],
            'original_title' => $validated['original_title'],
            'tagline' => $validated['tagline'],
            'synopsis' => $validated['synopsis'],
            'release_status' => $validated['release_status'],
            'release_date' => $validated['release_date'],
            'runtime_minutes' => $validated['runtime_minutes'],
            'age_rating' => $validated['age_rating'],
            'audio_language_code' => $validated['audio_language_code'],
            'subtitle_languages_json' => $validated['subtitle_languages'] ?? ['en', 'id'],
            'director_name' => $validated['director_name'],
            'studio_name' => $validated['studio_name'],
            'aspect_ratio' => $validated['aspect_ratio'],
            'audience_score' => $validated['audience_score'],
            'critic_score' => $validated['critic_score'],
            'poster_image_url' => $validated['poster_image_url'],
            'backdrop_image_url' => $validated['backdrop_image_url'],
            'is_featured' => $request->boolean('is_featured'),
            'is_trending' => $request->boolean('is_trending'),
        ]);

        if (isset($validated['genres'])) {
            $movie->genres()->sync($validated['genres']);
        }

        return redirect()->route('manage.movies.index')->with('status_toast', [
            'type' => 'success',
            'title' => 'Film Updated',
            'message' => "Changes to '{$movie->title}' saved.",
        ]);
    }

    public function destroy(Movie $movie): RedirectResponse
    {
        $title = $movie->title;
        $movie->delete();

        return redirect()->route('manage.movies.index')->with('status_toast', [
            'type' => 'info',
            'title' => 'Film Archived',
            'message' => "'{$title}' archived from catalog.",
        ]);
    }
}
