<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Contracts\StudioSyncProviderInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class StudioSyncSimulatorController extends Controller
{
    public function run(Request $request, StudioSyncProviderInterface $syncProvider): RedirectResponse
    {
        $validated = $request->validate([
            'source' => 'required|string',
            'outcome' => 'required|in:success,partial,timeout',
        ]);

        $result = $syncProvider->syncFeed($validated['source'], $validated['outcome']);

        $type = match ($result['status']) {
            'success' => 'success',
            'partial' => 'warning',
            default => 'error',
        };

        return back()->with('status_toast', [
            'type' => $type,
            'title' => 'Studio Sync Simulation',
            'message' => $result['message'],
        ]);
    }
}
