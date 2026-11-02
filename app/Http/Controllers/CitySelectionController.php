<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Contracts\GeolocationProviderInterface;
use App\Services\Simulators\SimulatedGeolocationService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CitySelectionController extends Controller
{
    public function update(Request $request, GeolocationProviderInterface $geo): RedirectResponse
    {
        $validated = $request->validate([
            'city_slug' => 'nullable|string|exists:cities,slug',
            'preset_key' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $city = null;

        // 1. If preset chosen from simulator
        if (!empty($validated['preset_key']) && isset(SimulatedGeolocationService::PRESETS[$validated['preset_key']])) {
            $preset = SimulatedGeolocationService::PRESETS[$validated['preset_key']];
            $city = City::where('slug', $preset['target_city'])->first();
            $request->session()->put('user_coords', [
                'lat' => $preset['lat'],
                'lng' => $preset['lng'],
                'preset_name' => $preset['name'],
            ]);
        }
        // 2. If raw coordinates passed
        elseif (!empty($validated['latitude']) && !empty($validated['longitude'])) {
            $city = $geo->resolveNearestCity((float) $validated['latitude'], (float) $validated['longitude']);
            $request->session()->put('user_coords', [
                'lat' => (float) $validated['latitude'],
                'lng' => (float) $validated['longitude'],
            ]);
        }
        // 3. If explicit city slug passed
        elseif (!empty($validated['city_slug'])) {
            $city = City::where('slug', $validated['city_slug'])->first();
            $request->session()->forget('user_coords');
        }

        if ($city) {
            $request->session()->put('active_city_id', $city->id);

            if ($request->user()) {
                $request->user()->update(['preferred_city_id' => $city->id]);
            }

            return back()->with('status_toast', [
                'type' => 'success',
                'title' => 'City Switched',
                'message' => "Now viewing cinema listings and showtimes for {$city->name}.",
            ]);
        }

        return back()->with('status_toast', [
            'type' => 'warning',
            'title' => 'Selection Unchanged',
            'message' => 'Please select a valid city from the circuit.',
        ]);
    }
}
