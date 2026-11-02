<?php

namespace App\Services\Simulators;

use App\Contracts\StudioSyncProviderInterface;
use App\Models\ExternalSyncLog;
use App\Models\Movie;

class DeterministicStudioSyncSimulator implements StudioSyncProviderInterface
{
    public function syncFeed(string $feedSource, string $simulationOutcome = 'success'): array
    {
        if ($simulationOutcome === 'timeout') {
            ExternalSyncLog::create([
                'source' => $feedSource,
                'status' => 'failed',
                'summary' => "Simulated gateway timeout (504 Gateway Timeout) connecting to upstream {$feedSource}.",
                'payload_json' => [
                    'outcome' => 'timeout',
                    'error_code' => 'ETIMEDOUT',
                    'simulated_latency_ms' => 4500,
                ],
            ]);

            return [
                'status' => 'failed',
                'message' => 'Simulated upstream feed connection timed out after 4500ms.',
                'synced_count' => 0,
            ];
        }

        if ($simulationOutcome === 'partial') {
            ExternalSyncLog::create([
                'source' => $feedSource,
                'status' => 'partial',
                'summary' => "Partial studio metadata synchronization: 2 titles verified, 1 title missing trailer asset.",
                'payload_json' => [
                    'outcome' => 'partial',
                    'synced_titles' => ['Chronos 2099', 'Neon Rain'],
                    'warnings' => ['Asset missing for upcoming title: The Whispering Gallery'],
                ],
            ]);

            return [
                'status' => 'partial',
                'message' => 'Studio feed completed with warnings: 2 movies refreshed, 1 missing artwork.',
                'synced_count' => 2,
            ];
        }

        // Default 'success'
        $count = Movie::count();
        // Update trending flag subtly
        Movie::query()->where('is_featured', false)->inRandomOrder()->take(2)->update(['is_trending' => true]);

        ExternalSyncLog::create([
            'source' => $feedSource,
            'status' => 'success',
            'summary' => "Successfully synchronized {$count} titles from {$feedSource}. Release schedules and trailer links verified.",
            'payload_json' => [
                'outcome' => 'success',
                'processed_records' => $count,
                'synced_at' => now()->toIso8601String(),
                'version' => 'StudioMetadata/2026.11',
            ],
        ]);

        return [
            'status' => 'success',
            'message' => "Successfully synchronized metadata and showtime dates from {$feedSource}.",
            'synced_count' => $count,
        ];
    }
}
