<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Movie;
use App\Models\City;
use App\Models\Watchlist;
use App\Models\ReleaseReminder;
use App\Models\ExternalSyncLog;
use App\Models\SimulatedNotificationLog;
use App\Models\DemoActivityLog;

class WatchlistAndLogsSeeder extends Seeder
{
    public function run(): void
    {
        $elena = User::where('persona_key', 'visitor_member')->first();
        $aria = User::where('persona_key', 'platform_admin')->first();
        $jakarta = City::where('slug', 'jakarta')->first();

        if ($elena) {
            $favMovies = Movie::take(4)->get();
            foreach ($favMovies as $m) {
                Watchlist::updateOrCreate(
                    ['user_id' => $elena->id, 'movie_id' => $m->id],
                    ['notes' => 'Cinephile priority screening']
                );
            }

            // Elena subscribes to 2 coming-soon titles
            $upcoming = Movie::where('release_status', 'coming_soon')->take(2)->get();
            foreach ($upcoming as $um) {
                if ($jakarta) {
                    ReleaseReminder::updateOrCreate(
                        ['user_id' => $elena->id, 'movie_id' => $um->id, 'city_id' => $jakarta->id],
                        ['status' => 'subscribed', 'notified_at' => null]
                    );

                    SimulatedNotificationLog::create([
                        'user_id' => $elena->id,
                        'movie_id' => $um->id,
                        'city_id' => $jakarta->id,
                        'channel' => 'email',
                        'recipient_email' => $elena->email,
                        'subject' => "🎟️ Confirmed Alert: {$um->title} in Jakarta",
                        'message_body' => "You will receive an opening night reminder when tickets and showtimes go live in Jakarta.",
                        'sent_at' => now()->subHours(2),
                    ]);
                }
            }
        }

        // Aria's initial studio sync logs
        ExternalSyncLog::create([
            'source' => 'Studio Direct Feed (A24 / Neon Indie Archive)',
            'status' => 'success',
            'summary' => 'Initial automated catalog sync: 16 titles validated, 32 trailer streams active.',
            'payload_json' => [
                'batch_id' => 'SYNC-20261102-001',
                'status' => 'success',
                'verified_records' => 16,
            ],
        ]);

        // Initial Demo Activity Log
        DemoActivityLog::create([
            'user_id' => $aria?->id,
            'persona_key' => 'platform_admin',
            'event_type' => 'catalog_published',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'MatineeSystem/1.0',
            'payload_json' => ['action' => 'Published 16 movies with Art-Deco aesthetic'],
            'created_at' => now(),
        ]);
    }
}
