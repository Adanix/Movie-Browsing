<?php

namespace App\Services\Simulators;

use App\Contracts\TrailerProviderInterface;
use App\Models\Movie;
use App\Models\MovieTrailer;

class LocalTheatricalTrailerService implements TrailerProviderInterface
{
    public function resolveTrailer(Movie $movie, ?int $trailerId = null): array
    {
        $trailer = null;
        if ($trailerId) {
            $trailer = $movie->trailers()->find($trailerId);
        }

        if (!$trailer) {
            $trailer = $movie->primaryTrailer ?? $movie->trailers()->first();
        }

        if ($trailer) {
            $trailer->increment('view_count');
        }

        $storyboard = $trailer?->storyboard_config_json ?? [
            [
                'time' => '00:00',
                'title' => 'Prologue',
                'quote' => $movie->tagline ?: 'In an era of illuminated marquees and whispered secrets...',
                'visual' => 'deco_sunburst',
            ],
            [
                'time' => '00:45',
                'title' => 'The Turning Point',
                'quote' => substr($movie->synopsis, 0, 160) . '...',
                'visual' => 'velvet_curtain',
            ],
            [
                'time' => '01:30',
                'title' => 'Climax & Title Card',
                'quote' => strtoupper($movie->title) . ' — Directed by ' . ($movie->director_name ?: 'Aria Vance'),
                'visual' => 'marquee_neon',
            ],
        ];

        return [
            'movie' => [
                'id' => $movie->id,
                'title' => $movie->title,
                'slug' => $movie->slug,
                'age_rating' => $movie->age_rating,
                'runtime' => $movie->formattedRuntime(),
                'audio_language' => $movie->audio_language_code,
                'subtitles' => $movie->subtitle_languages_json ?? ['en', 'id'],
            ],
            'trailer' => [
                'id' => $trailer?->id,
                'title' => $trailer?->title ?? 'Official Theatrical Premiere Trailer',
                'type' => $trailer?->trailer_type ?? 'official_trailer',
                'duration' => $trailer?->duration_seconds ?? 135,
                'formatted_duration' => '2:15',
                'stream_url' => $trailer?->video_stream_url ?: 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                'views' => $trailer?->view_count ?? 1,
            ],
            'storyboard' => $storyboard,
        ];
    }
}
