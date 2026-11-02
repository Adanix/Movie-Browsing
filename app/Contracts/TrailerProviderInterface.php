<?php

namespace App\Contracts;

use App\Models\Movie;

interface TrailerProviderInterface
{
    /**
     * Resolve trailer stream or interactive storyboard for a movie.
     */
    public function resolveTrailer(Movie $movie, ?int $trailerId = null): array;
}
