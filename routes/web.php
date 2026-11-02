<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\PublicDocsController;
use App\Http\Controllers\DemoAuthController;
use App\Http\Controllers\MovieCatalogController;
use App\Http\Controllers\MovieTrailerController;
use App\Http\Controllers\MovieCalendarController;
use App\Http\Controllers\CitySelectionController;
use App\Http\Controllers\CinemaDirectoryController;
use App\Http\Controllers\ShowtimeSlotPreviewController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\Manage\DashboardController;
use App\Http\Controllers\Manage\MovieManagementController;
use App\Http\Controllers\Manage\CinemaManagementController;
use App\Http\Controllers\Manage\ShowtimeManagementController;
use App\Http\Controllers\Manage\StudioSyncSimulatorController;

// -----------------------------------------------------------------------------
// P0 Canonical Public & Demo Entry Routes
// -----------------------------------------------------------------------------
Route::get('/', [PublicHomeController::class, 'index'])->name('public.home');
Route::get('/docs', [PublicDocsController::class, 'index'])->name('public.docs');

Route::middleware('demo.mode')->group(function () {
    Route::get('/demo/login', [DemoAuthController::class, 'showLogin'])->name('demo.login');
    Route::get('/login', fn () => redirect()->route('demo.login'))->name('login');
    Route::post('/demo/quick-login', [DemoAuthController::class, 'quickLogin'])
        ->middleware('throttle:30,1')
        ->name('demo.quick-login');
});

Route::post('/logout', [DemoAuthController::class, 'logout'])->middleware('auth')->name('logout');

// -----------------------------------------------------------------------------
// Core Browsing & Discovery Routes
// -----------------------------------------------------------------------------
Route::get('/movies', [MovieCatalogController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie:slug}', [MovieCatalogController::class, 'show'])->name('movies.show');
Route::get('/movies/{movie:slug}/trailer', [MovieTrailerController::class, 'show'])->name('movies.trailer');
Route::get('/movies/{movie:slug}/calendar.ics', [MovieCalendarController::class, 'download'])->name('movies.calendar');

Route::post('/city/select', [CitySelectionController::class, 'update'])->name('city.select');
Route::get('/cinemas', [CinemaDirectoryController::class, 'index'])->name('cinemas.index');
Route::get('/cinemas/{cinema:slug}', [CinemaDirectoryController::class, 'show'])->name('cinemas.show');

// Phase 2 Slot-In Preview Boundary
Route::get('/showtimes/{showtime}/slot-preview', [ShowtimeSlotPreviewController::class, 'show'])->name('showtimes.slot-preview');
Route::get('/showtimes/{showtime}/preview', [ShowtimeSlotPreviewController::class, 'show'])->name('showtimes.preview');

// Member Watchlist & Reminders
Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
Route::post('/watchlist/toggle', [WatchlistController::class, 'toggle'])->name('watchlist.toggle');
Route::post('/watchlist/{movie}/reminder', [WatchlistController::class, 'storeReminder'])->middleware('auth')->name('watchlist.reminder');

// -----------------------------------------------------------------------------
// Backoffice Management Routes
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'role:platform_admin,cinema_manager'])->prefix('manage')->name('manage.')->group(function () {
    Route::get('/', fn() => redirect()->route('manage.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cinema & Auditorium Management
    Route::get('/cinemas', [CinemaManagementController::class, 'index'])->name('cinemas.index');
    Route::get('/cinemas/{cinema}/edit', [CinemaManagementController::class, 'edit'])->name('cinemas.edit');
    Route::put('/cinemas/{cinema}', [CinemaManagementController::class, 'update'])->name('cinemas.update');

    // Showtime Scheduler
    Route::get('/showtimes', [ShowtimeManagementController::class, 'index'])->name('showtimes.index');
    Route::post('/showtimes', [ShowtimeManagementController::class, 'store'])->name('showtimes.store');
    Route::delete('/showtimes/{showtime}', [ShowtimeManagementController::class, 'destroy'])->name('showtimes.destroy');

    // Platform Admin Only
    Route::middleware('role:platform_admin')->group(function () {
        Route::resource('movies', MovieManagementController::class)->except(['show']);
        Route::post('/sync-simulator/run', [StudioSyncSimulatorController::class, 'run'])->name('sync.run');
    });
});
