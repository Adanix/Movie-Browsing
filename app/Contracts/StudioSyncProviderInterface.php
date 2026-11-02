<?php

namespace App\Contracts;

interface StudioSyncProviderInterface
{
    /**
     * Run simulated studio feed metadata sync.
     */
    public function syncFeed(string $feedSource, string $simulationOutcome): array;
}
