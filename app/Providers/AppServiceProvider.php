<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\TicketingSlotInterface;
use App\Services\Ticketing\PhaseOnePreviewSlotAdapter;
use App\Contracts\GeolocationProviderInterface;
use App\Services\Simulators\SimulatedGeolocationService;
use App\Contracts\TrailerProviderInterface;
use App\Services\Simulators\LocalTheatricalTrailerService;
use App\Contracts\StudioSyncProviderInterface;
use App\Services\Simulators\DeterministicStudioSyncSimulator;
use App\Contracts\NotificationProviderInterface;
use App\Services\Simulators\DatabaseNotificationSimulator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TicketingSlotInterface::class, PhaseOnePreviewSlotAdapter::class);
        $this->app->bind(GeolocationProviderInterface::class, SimulatedGeolocationService::class);
        $this->app->bind(TrailerProviderInterface::class, LocalTheatricalTrailerService::class);
        $this->app->bind(StudioSyncProviderInterface::class, DeterministicStudioSyncSimulator::class);
        $this->app->bind(NotificationProviderInterface::class, DatabaseNotificationSimulator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::anonymousComponentPath(resource_path('views/layouts'), 'layouts');
    }
}
