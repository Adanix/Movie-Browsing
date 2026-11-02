<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Cinema;
use App\Models\Auditorium;
use App\Models\User;

class CinemaSeeder extends Seeder
{
    public function run(): void
    {
        $manager = User::where('persona_key', 'cinema_manager')->first();

        $cinemaData = [
            // JAKARTA (4 cinemas)
            [
                'city_slug' => 'jakarta',
                'name' => 'Matinee Grand Palace Senayan',
                'slug' => 'matinee-grand-palace-senayan',
                'neighborhood' => 'Senayan, Jakarta Selatan',
                'address_line' => 'Jl. Asia Afrika No. 8, Gelora, Tanah Abang',
                'latitude' => -6.225014,
                'longitude' => 106.802872,
                'phone_number' => '+62 21 5790 1931',
                'hero_badge' => 'Flagship Laser IMAX & Grand House',
                'architectural_style' => '1930s Art-Deco Palais with Lit Marquee Dome',
                'amenities' => ['IMAX Laser 4K', 'Dolby Atmos', 'Art-Deco Cocktail Bar', 'Wheelchair Step-Free', 'Valet Parking'],
                'hours' => ['open' => '09:30', 'close' => '23:45'],
                'auditoriums' => [
                    ['name' => 'Auditorium 1 · The Grand Palace', 'format' => 'Dolby Atmos Grand House', 'sound' => 'Dolby Atmos 128-ch', 'capacity' => 280],
                    ['name' => 'Auditorium 2 · IMAX with Laser', 'format' => 'IMAX Laser 4K', 'sound' => 'IMAX 12-channel Immersion', 'capacity' => 340],
                    ['name' => 'Auditorium 3 · Velvet Gold Club', 'format' => 'VIP Recliner', 'sound' => 'Dolby Atmos', 'capacity' => 64],
                ],
            ],
            [
                'city_slug' => 'jakarta',
                'name' => 'Garnet Kemang Arthouse',
                'slug' => 'garnet-kemang-arthouse',
                'neighborhood' => 'Kemang, Jakarta Selatan',
                'address_line' => 'Jl. Kemang Raya No. 45B, Bangka, Mampang Prapatan',
                'latitude' => -6.262512,
                'longitude' => 106.815340,
                'phone_number' => '+62 21 7192 1934',
                'hero_badge' => 'Archival 35mm & Indie Showcase',
                'architectural_style' => 'Streamline Moderne Cinema with Garden Terrace',
                'amenities' => ['35mm Film Projector', '4K Digital Barco', 'Boutique Coffee Lounge', 'Earphone Assisted Audio'],
                'hours' => ['open' => '11:00', 'close' => '23:00'],
                'auditoriums' => [
                    ['name' => 'Hall A · Celluloid Vault', 'format' => '35mm Archival Film', 'sound' => '7.1 Archival Audio', 'capacity' => 120],
                    ['name' => 'Hall B · The Screening Room', 'format' => '4K Digital Cinema', 'sound' => 'Dolby Atmos', 'capacity' => 96],
                ],
            ],
            [
                'city_slug' => 'jakarta',
                'name' => 'Matinee PIK Avenue IMAX',
                'slug' => 'matinee-pik-avenue-imax',
                'neighborhood' => 'Pantai Indah Kapuk, Jakarta Utara',
                'address_line' => 'PIK Avenue Mall Lt. 3, Jl. Pantai Indah Kapuk Boulevard',
                'latitude' => -6.109240,
                'longitude' => 106.740870,
                'phone_number' => '+62 21 2257 0888',
                'hero_badge' => 'Coastal IMAX & Panoramic Sound',
                'architectural_style' => 'Futuristic Art-Deco with Gilded Curved Pillars',
                'amenities' => ['IMAX Laser', 'Dolby Atmos', 'Gourmet Concession', 'Step-Free Access'],
                'hours' => ['open' => '10:00', 'close' => '23:30'],
                'auditoriums' => [
                    ['name' => 'Auditorium 1 · IMAX Experience', 'format' => 'IMAX Laser', 'sound' => 'IMAX 12-ch Audio', 'capacity' => 310],
                    ['name' => 'Auditorium 2 · Studio Atmos', 'format' => '4K Digital Cinema', 'sound' => 'Dolby Atmos', 'capacity' => 180],
                    ['name' => 'Auditorium 3 · Premiere Lounge', 'format' => 'VIP Recliner', 'sound' => 'Dolby 7.1', 'capacity' => 72],
                ],
            ],
            [
                'city_slug' => 'jakarta',
                'name' => 'Grand Menteng Repertory 1938',
                'slug' => 'grand-menteng-repertory-1938',
                'neighborhood' => 'Menteng, Jakarta Pusat',
                'address_line' => 'Jl. Teuku Cik Ditiro No. 19, Menteng',
                'latitude' => -6.197820,
                'longitude' => 106.842130,
                'phone_number' => '+62 21 3190 1938',
                'hero_badge' => 'Heritage Repertory & Restored Classics',
                'architectural_style' => 'Dutch Colonial Art-Deco Theater Built in 1938',
                'amenities' => ['35mm Film Projector', 'Art-Deco Balcony', 'Vintage Concession Bar'],
                'hours' => ['open' => '12:00', 'close' => '22:30'],
                'auditoriums' => [
                    ['name' => 'The Main Auditorium (Stalls & Balcony)', 'format' => '35mm & 4K Digital', 'sound' => 'Altec Restored Vintage Acoustic', 'capacity' => 220],
                ],
            ],

            // BANDUNG (2 cinemas)
            [
                'city_slug' => 'bandung',
                'name' => 'Matinee Braga Heritage 1931',
                'slug' => 'matinee-braga-heritage-1931',
                'neighborhood' => 'Braga, Bandung',
                'address_line' => 'Jl. Braga No. 58, Sumur Bandung',
                'latitude' => -6.917464,
                'longitude' => 107.619123,
                'phone_number' => '+62 22 423 1931',
                'hero_badge' => 'Historic Braga Marquee & 35mm Celluloid',
                'architectural_style' => 'Authentic 1931 Nieuwe Bouwen Art-Deco Cinema',
                'amenities' => ['35mm Film Projector', 'Dolby Atmos', 'Heritage Walk-in Gallery', 'Braga Coffee Stand'],
                'hours' => ['open' => '10:00', 'close' => '23:00'],
                'auditoriums' => [
                    ['name' => 'Sala 1 · Gedung Braga Utama', 'format' => '35mm Archival Film', 'sound' => 'Dolby Atmos', 'capacity' => 210],
                    ['name' => 'Sala 2 · Studio Pasundan', 'format' => '4K Digital Barco', 'sound' => '7.1 Surround', 'capacity' => 140],
                ],
            ],
            [
                'city_slug' => 'bandung',
                'name' => 'Dago Hilltop Cinema & Lounge',
                'slug' => 'dago-hilltop-cinema-and-lounge',
                'neighborhood' => 'Dago Atas, Bandung',
                'address_line' => 'Jl. Ir. H. Juanda No. 340, Dago, Coblong',
                'latitude' => -6.872410,
                'longitude' => 107.620890,
                'phone_number' => '+62 22 250 4889',
                'hero_badge' => 'Pine Forest Amphitheater & Laser Hall',
                'architectural_style' => 'Modern Art-Deco with Panoramic Mountain Terraces',
                'amenities' => ['Dolby Atmos Laser', 'Outdoor Garden Waiting Area', 'Wheelchair Accessible'],
                'hours' => ['open' => '11:30', 'close' => '23:00'],
                'auditoriums' => [
                    ['name' => 'Cinema 1 · Dago Peak', 'format' => 'Dolby Atmos Laser', 'sound' => 'Dolby Atmos', 'capacity' => 160],
                    ['name' => 'Cinema 2 · Velvet Club', 'format' => 'VIP Recliner', 'sound' => '7.1 Surround', 'capacity' => 60],
                ],
            ],

            // SURABAYA (2 cinemas)
            [
                'city_slug' => 'surabaya',
                'name' => 'Tunjungan Noir Multiplex',
                'slug' => 'tunjungan-noir-multiplex',
                'neighborhood' => 'Tunjungan, Surabaya Pusat',
                'address_line' => 'Jl. Tunjungan No. 65, Genteng',
                'latitude' => -7.261882,
                'longitude' => 112.741875,
                'phone_number' => '+62 31 534 1935',
                'hero_badge' => 'High-Contrast Noir Hall & Laser IMAX',
                'architectural_style' => 'Noir Marquee with Black Granite & Golden Ribbons',
                'amenities' => ['IMAX Laser', 'Dolby Atmos', 'Tunjungan Heritage Bar', 'Assisted Listening'],
                'hours' => ['open' => '10:00', 'close' => '23:30'],
                'auditoriums' => [
                    ['name' => 'Hall 1 · Tunjungan IMAX Laser', 'format' => 'IMAX Laser 4K', 'sound' => 'IMAX Immersion Audio', 'capacity' => 320],
                    ['name' => 'Hall 2 · The Noir Stage', 'format' => 'Dolby Atmos Grand House', 'sound' => 'Dolby Atmos', 'capacity' => 190],
                ],
            ],
            [
                'city_slug' => 'surabaya',
                'name' => 'Matinee Pakuwon City Hall',
                'slug' => 'matinee-pakuwon-city-hall',
                'neighborhood' => 'Pakuwon City, Surabaya Timur',
                'address_line' => 'Pakuwon City Mall Lt. 2, Kejawan Putih Tambak',
                'latitude' => -7.279810,
                'longitude' => 112.798120,
                'phone_number' => '+62 31 591 7890',
                'hero_badge' => 'Family Premiere & Sensory-Friendly Hub',
                'architectural_style' => 'Contemporary Art-Deco Cinema with Velvet Chandelier Foyer',
                'amenities' => ['4K Laser Digital', 'Dolby 7.1', 'Sensory-Friendly Screenings', 'Pram / Stroller Parking'],
                'hours' => ['open' => '10:00', 'close' => '23:00'],
                'auditoriums' => [
                    ['name' => 'Studio 1 · Grand Laser', 'format' => '4K Digital Barco', 'sound' => 'Dolby Atmos', 'capacity' => 180],
                    ['name' => 'Studio 2 · Matinee Kids & Family', 'format' => 'Standard Digital', 'sound' => '7.1 Sound', 'capacity' => 130],
                ],
            ],

            // BALI (2 cinemas)
            [
                'city_slug' => 'bali',
                'name' => 'Seminyak Sunset Screening House',
                'slug' => 'seminyak-sunset-screening-house',
                'neighborhood' => 'Seminyak, Badung',
                'address_line' => 'Jl. Kayu Aya No. 22, Seminyak, Kuta',
                'latitude' => -8.691307,
                'longitude' => 115.168228,
                'phone_number' => '+62 361 738 1930',
                'hero_badge' => 'Tropical Art-Deco Cinema & Open-Air Bar',
                'architectural_style' => 'Tropical Art-Deco with Teakwood Louvers & Marquee Lanterns',
                'amenities' => ['4K Laser Cinema', 'Dolby Atmos', 'Sunset Cocktail Lounge', 'Bilingual Subtitles'],
                'hours' => ['open' => '12:00', 'close' => '23:45'],
                'auditoriums' => [
                    ['name' => 'The Gold Room · Main Auditorium', 'format' => '4K Laser Digital', 'sound' => 'Dolby Atmos', 'capacity' => 140],
                    ['name' => 'The Palms · Velvet VIP', 'format' => 'VIP Recliner', 'sound' => '7.1 Surround', 'capacity' => 50],
                ],
            ],
            [
                'city_slug' => 'bali',
                'name' => 'Garnet Denpasar Palace',
                'slug' => 'garnet-denpasar-palace',
                'neighborhood' => 'Renon, Denpasar',
                'address_line' => 'Jl. Raya Puputan No. 102, Renon, Denpasar Selatan',
                'latitude' => -8.670458,
                'longitude' => 115.228710,
                'phone_number' => '+62 361 240 8812',
                'hero_badge' => 'Premiere Multiplex & Film Festival Hub',
                'architectural_style' => 'Classic Balinese Deco with Gilded Temple Stone Motifs',
                'amenities' => ['Dolby Atmos', 'Film Festival Screening Suite', 'Wheelchair Access'],
                'hours' => ['open' => '10:30', 'close' => '23:00'],
                'auditoriums' => [
                    ['name' => 'Auditorium A · Puputan Hall', 'format' => '4K Digital Barco', 'sound' => 'Dolby Atmos', 'capacity' => 180],
                    ['name' => 'Auditorium B · Sanur Studio', 'format' => 'Standard Digital', 'sound' => '7.1 Sound', 'capacity' => 120],
                ],
            ],

            // MISSOULA, MONTANA (1 cinema — The 1931 Garnet Flagship)
            [
                'city_slug' => 'missoula',
                'name' => 'The 1931 Garnet Theater',
                'slug' => 'the-1931-garnet-theater',
                'neighborhood' => 'Downtown Historic District, Missoula',
                'address_line' => '214 N Higgins Ave, Missoula, MT 59802',
                'latitude' => 46.872150,
                'longitude' => -113.994019,
                'phone_number' => '+1 406 543 1931',
                'hero_badge' => 'The Original 1931 Freeframe Matinee Lore Flagship',
                'architectural_style' => 'Garnet Red Velvet & Pure 1931 Montana Art-Deco Cinema Palace',
                'amenities' => ['Restored 35mm Carbon-Arc Projector', '4K Digital Christie', 'Real Butter Marquee Popcorn', 'Hearing Loop Induction'],
                'hours' => ['open' => '12:00', 'close' => '23:00'],
                'auditoriums' => [
                    ['name' => 'The Main Auditorium · 1931 Historic Hall', 'format' => '35mm Film & 4K Digital', 'sound' => 'Altec Voice of the Theatre + 7.1', 'capacity' => 310],
                    ['name' => 'The Balcony Screening Room', 'format' => 'Boutique 35mm', 'sound' => 'Stereo Optical Archival', 'capacity' => 80],
                ],
            ],
        ];

        foreach ($cinemaData as $c) {
            $city = City::where('slug', $c['city_slug'])->first();
            if (!$city) continue;

            $cinema = Cinema::updateOrCreate(
                ['slug' => $c['slug']],
                [
                    'city_id' => $city->id,
                    'manager_user_id' => $manager?->id,
                    'name' => $c['name'],
                    'neighborhood' => $c['neighborhood'],
                    'address_line' => $c['address_line'],
                    'latitude' => $c['latitude'],
                    'longitude' => $c['longitude'],
                    'phone_number' => $c['phone_number'],
                    'transit_and_parking_note' => 'Dedicated basement parking available. Drop-off concourse in front of lit marquee.',
                    'opening_hours_json' => $c['hours'],
                    'amenities_json' => $c['amenities'],
                    'architectural_style' => $c['architectural_style'],
                    'hero_badge' => $c['hero_badge'],
                    'is_active' => true,
                ]
            );

            foreach ($c['auditoriums'] as $a) {
                Auditorium::updateOrCreate(
                    [
                        'cinema_id' => $cinema->id,
                        'name' => $a['name'],
                    ],
                    [
                        'screen_format' => $a['format'],
                        'sound_system' => $a['sound'],
                        'total_capacity' => $a['capacity'],
                        'rows_count' => ceil($a['capacity'] / 16),
                        'seats_per_row' => 16,
                        'is_step_free' => true,
                    ]
                );
            }
        }
    }
}
