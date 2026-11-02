<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Showtime;

class MovieCatalogAndDiscoveryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_movies_index_lists_titles_and_supports_filtering(): void
    {
        $response = $this->get('/movies');

        $response->assertStatus(200);
        $response->assertSee('Theatrical Film Catalog');

        // Test filter by query
        $movie = Movie::where('release_status', 'now_showing')->first();
        $searchResponse = $this->get('/movies?q=' . urlencode(substr($movie->title, 0, 5)));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee($movie->title);
    }

    public function test_movie_detail_page_renders_with_schedule(): void
    {
        $movie = Movie::where('release_status', 'now_showing')->first();

        $response = $this->get('/movies/' . $movie->slug);

        $response->assertStatus(200);
        $response->assertSee($movie->title);
        $response->assertSee($movie->director_name);
    }

    public function test_movie_calendar_ics_export(): void
    {
        $movie = Movie::where('release_status', 'now_showing')->first();
        $showtime = Showtime::where('movie_id', $movie->id)->first();

        $response = $this->get("/movies/{$movie->slug}/calendar.ics?showtime_id={$showtime->id}");

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/calendar; charset=utf-8');
        $this->assertStringContainsString('BEGIN:VCALENDAR', $response->getContent());
        $this->assertStringContainsString($movie->title, $response->getContent());
    }

    public function test_cinemas_index_and_detail_routes(): void
    {
        $response = $this->get('/cinemas');
        $response->assertStatus(200);
        $response->assertSee('Circuit Cinemas');

        $cinema = Cinema::first();
        $cinemaResponse = $this->get('/cinemas/' . $cinema->slug);
        $cinemaResponse->assertStatus(200);
        $cinemaResponse->assertSee($cinema->name);
    }

    public function test_showtime_slot_preview_json_and_html(): void
    {
        $showtime = Showtime::first();

        // JSON API format
        $jsonResponse = $this->getJson("/showtimes/{$showtime->id}/preview");
        $jsonResponse->assertStatus(200);
        $jsonResponse->assertJsonStructure([
            'showtime_id',
            'movie' => ['id', 'title', 'slug'],
            'cinema' => ['id', 'name', 'city'],
            'auditorium' => ['id', 'name', 'format'],
            'schedule' => ['date', 'starts_at'],
            'pricing' => ['amount', 'formatted'],
            'seats' => ['available_estimate'],
            'readiness',
        ]);
        $this->assertEquals('PHASE_2_SLOT_IN_READY', $jsonResponse->json('readiness'));

        // HTML drawer format
        $htmlResponse = $this->get("/showtimes/{$showtime->id}/preview");
        $htmlResponse->assertStatus(200);
        $htmlResponse->assertSee('Theatrical Slot Context');
    }
}
