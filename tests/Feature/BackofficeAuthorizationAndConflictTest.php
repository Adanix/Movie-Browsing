<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use App\Models\Movie;
use App\Models\Auditorium;
use App\Models\PricingTier;
use App\Models\Showtime;
use Carbon\Carbon;

class BackofficeAuthorizationAndConflictTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_guest_is_redirected_when_accessing_backoffice(): void
    {
        $response = $this->get('/manage');
        $response->assertRedirect('/demo/login');
    }

    public function test_visitor_member_is_forbidden_from_backoffice(): void
    {
        $member = User::where('role', 'visitor_member')->first();
        $response = $this->actingAs($member)->get('/manage');
        $response->assertStatus(403);
    }

    public function test_cinema_manager_can_access_dashboard_and_showtimes(): void
    {
        $manager = User::where('role', 'cinema_manager')->first();
        $response = $this->actingAs($manager)->get('/manage/dashboard');
        $response->assertStatus(200);

        $showtimesResponse = $this->actingAs($manager)->get('/manage/showtimes');
        $showtimesResponse->assertStatus(200);
    }

    public function test_cinema_manager_is_forbidden_from_master_film_catalog(): void
    {
        $manager = User::where('role', 'cinema_manager')->first();
        $response = $this->actingAs($manager)->get('/manage/movies');
        $response->assertStatus(403);
    }

    public function test_platform_admin_can_access_film_catalog_and_sync_simulator(): void
    {
        $admin = User::where('role', 'platform_admin')->first();
        $response = $this->actingAs($admin)->get('/manage/movies');
        $response->assertStatus(200);

        // Test studio sync simulator endpoint
        $syncResponse = $this->actingAs($admin)
            ->from(route('manage.dashboard'))
            ->post(route('manage.sync.run'), [
                'source' => 'Warner Brothers / Universal Feed',
                'outcome' => 'success',
            ]);
        $syncResponse->assertRedirect(route('manage.dashboard'));
        $syncResponse->assertSessionHas('status_toast');
    }

    public function test_showtime_conflict_engine_prevents_double_booking(): void
    {
        $admin = User::where('role', 'platform_admin')->first();
        $movie = Movie::first();
        $auditorium = Auditorium::first();
        $pricing = PricingTier::first();

        // 1. Create initial screening at 14:00
        Showtime::create([
            'movie_id' => $movie->id,
            'cinema_id' => $auditorium->cinema_id,
            'auditorium_id' => $auditorium->id,
            'pricing_tier_id' => $pricing->id,
            'screening_date' => now()->addDays(5)->format('Y-m-d'),
            'starts_at' => Carbon::parse(now()->addDays(5)->format('Y-m-d') . ' 14:00:00'),
            'ends_at' => Carbon::parse(now()->addDays(5)->format('Y-m-d') . ' 16:30:00'),
            'presentation_format' => 'Dolby Cinema Atmos',
            'audio_language_code' => 'en',
            'available_seats_estimate' => 150,
            'status' => 'scheduled',
        ]);

        // 2. Attempt to schedule overlapping screening at 15:00 in the SAME hall
        $response = $this->actingAs($admin)->post('/manage/showtimes', [
            'movie_id' => $movie->id,
            'cinema_id' => $auditorium->cinema_id,
            'auditorium_id' => $auditorium->id,
            'pricing_tier_id' => $pricing->id,
            'screening_date' => now()->addDays(5)->format('Y-m-d'),
            'start_time' => '15:00',
            'presentation_format' => 'Dolby Cinema Atmos',
        ]);

        $response->assertSessionHasErrors(['start_time']);
    }
}
