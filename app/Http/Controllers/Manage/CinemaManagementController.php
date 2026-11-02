<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CinemaManagementController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Cinema::with(['city', 'auditoriums']);

        if ($user->role === 'cinema_manager') {
            $query->whereHas('city', fn($q) => $q->whereIn('slug', ['jakarta', 'bandung']));
        }

        $cinemas = $query->paginate(12);
        return view('manage.cinemas.index', compact('cinemas'));
    }

    public function edit(Cinema $cinema, Request $request): View
    {
        $this->authorize('update', $cinema);

        $cinema->load(['city', 'auditoriums']);
        return view('manage.cinemas.edit', compact('cinema'));
    }

    public function update(Request $request, Cinema $cinema): RedirectResponse
    {
        $this->authorize('update', $cinema);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'neighborhood' => 'required|string|max:120',
            'address_line' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:40',
            'hero_badge' => 'nullable|string|max:80',
            'architectural_style' => 'nullable|string|max:120',
            'transit_and_parking_note' => 'nullable|string',
            'open_time' => 'required|string|max:10',
            'close_time' => 'required|string|max:10',
            'is_active' => 'boolean',
        ]);

        $cinema->update([
            'name' => $validated['name'],
            'neighborhood' => $validated['neighborhood'],
            'address_line' => $validated['address_line'],
            'phone_number' => $validated['phone_number'],
            'hero_badge' => $validated['hero_badge'],
            'architectural_style' => $validated['architectural_style'],
            'transit_and_parking_note' => $validated['transit_and_parking_note'],
            'opening_hours_json' => [
                'open' => $validated['open_time'],
                'close' => $validated['close_time'],
            ],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('manage.cinemas.index')->with('status_toast', [
            'type' => 'success',
            'title' => 'Cinema Updated',
            'message' => "Venue settings for '{$cinema->name}' saved.",
        ]);
    }
}
