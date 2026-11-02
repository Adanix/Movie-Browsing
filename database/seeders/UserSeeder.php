<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $jakarta = City::where('slug', 'jakarta')->first();

        // 1. Cinema Member: Elena Vance
        User::updateOrCreate(
            ['email' => 'elena.vance@demo.matinee.test'],
            [
                'name' => 'Elena Vance',
                'password' => Hash::make('secret123'),
                'role' => 'visitor_member',
                'persona_key' => 'visitor_member',
                'preferred_city_id' => $jakarta?->id,
                'preferred_language_code' => 'en',
                'is_demo_user' => true,
            ]
        );

        // 2. Cinema Manager: Marcus Sterling
        User::updateOrCreate(
            ['email' => 'marcus.sterling@demo.matinee.test'],
            [
                'name' => 'Marcus Sterling',
                'password' => Hash::make('secret123'),
                'role' => 'cinema_manager',
                'persona_key' => 'cinema_manager',
                'preferred_city_id' => $jakarta?->id,
                'preferred_language_code' => 'id',
                'is_demo_user' => true,
            ]
        );

        // 3. Platform Curator / Admin: Aria Chen
        User::updateOrCreate(
            ['email' => 'aria.chen@demo.matinee.test'],
            [
                'name' => 'Aria Chen',
                'password' => Hash::make('secret123'),
                'role' => 'platform_admin',
                'persona_key' => 'platform_admin',
                'preferred_city_id' => $jakarta?->id,
                'preferred_language_code' => 'en',
                'is_demo_user' => true,
            ]
        );
    }
}
