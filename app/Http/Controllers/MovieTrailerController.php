<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Contracts\TrailerProviderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieTrailerController extends Controller
{
    public function show(Movie $movie, Request $request, TrailerProviderInterface $trailerProvider): JsonResponse
    {
        $trailerId = $request->query('trailer_id') ? (int) $request->query('trailer_id') : null;
        $data = $trailerProvider->resolveTrailer($movie, $trailerId);

        return response()->json($data);
    }
}
