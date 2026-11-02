<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            UserSeeder::class,
            GenreAndLanguageSeeder::class,
            PricingTierSeeder::class,
            CinemaSeeder::class,
            MovieSeeder::class,
            ShowtimeSeeder::class,
            WatchlistAndLogsSeeder::class,
        ]);
    }
}
