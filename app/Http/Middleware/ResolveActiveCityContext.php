<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\City;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ResolveActiveCityContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $allCities = City::query()->orderBy('sort_order')->orderBy('name')->get();

        $activeCity = null;

        // 1. Explicit query parameter ?city=slug
        if ($request->has('city') && filled($request->query('city'))) {
            $slug = $request->query('city');
            $found = $allCities->firstWhere('slug', $slug);
            if ($found) {
                $activeCity = $found;
                $request->session()->put('active_city_id', $found->id);
            }
        }

        // 2. Active session value
        if (!$activeCity && $request->session()->has('active_city_id')) {
            $sessId = $request->session()->get('active_city_id');
            $activeCity = $allCities->firstWhere('id', $sessId);
        }

        // 3. Authenticated user's preferred city
        if (!$activeCity && $request->user() && $request->user()->preferred_city_id) {
            $activeCity = $allCities->firstWhere('id', $request->user()->preferred_city_id);
            if ($activeCity) {
                $request->session()->put('active_city_id', $activeCity->id);
            }
        }

        // 4. Default city fallback
        if (!$activeCity) {
            $defaultSlug = config('demo.default_city_slug', 'jakarta');
            $activeCity = $allCities->firstWhere('slug', $defaultSlug) ?? $allCities->first();
            if ($activeCity) {
                $request->session()->put('active_city_id', $activeCity->id);
            }
        }

        // Share globally with all Blade views
        View::share('activeCity', $activeCity);
        View::share('allCities', $allCities);

        $watchlistCount = 0;
        if ($request->user()) {
            $watchlistCount = Watchlist::where('user_id', $request->user()->id)->count();
        } else {
            $guestList = $request->session()->get('guest_watchlist', []);
            $watchlistCount = count($guestList);
        }
        View::share('watchlistCount', $watchlistCount);

        return $next($request);
    }
}
