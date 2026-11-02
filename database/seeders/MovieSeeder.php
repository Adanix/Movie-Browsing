<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\MovieCredit;
use App\Models\MovieTrailer;
use Carbon\Carbon;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        $movies = [
            // FEATURED HERO 1: Sci-Fi / Japanese
            [
                'title' => 'Chronos 2099: Neo Shinjuku',
                'original_title' => 'クロノス2099：ネオ新宿',
                'slug' => 'chronos-2099-neo-shinjuku',
                'tagline' => 'Time is a fragile illusion under neon rainfall.',
                'synopsis' => 'In a submerged dystopian Tokyo rebuilt upon electromagnetic spires, an archival chronologist discovers a corrupted memory drive containing forbidden blueprints of the city before the great blackout of 2051. Targeted by synthetic syndicate operatives, she must race across subterranean hyper-transit corridors to transmit the truth to humanity.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(12)->toDateString(),
                'runtime_minutes' => 148,
                'age_rating' => '13+',
                'audio_language_code' => 'ja',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Kenjiro Takahashi',
                'studio_name' => 'Toho Cybernetics & Matinee Studios',
                'country_of_origin' => 'Japan',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => 'Dolby Atmos 9.1',
                'audience_score' => 9.4,
                'critic_score' => 96,
                'poster_palette' => ['bg' => '#0F172A', 'accent' => '#38BDF8', 'secondary' => '#F43F5E', 'motif' => 'deco_sunburst', 'icon' => 'sparkles'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'is_trending' => true,
                'featured_sort_order' => 1,
                'genres' => ['sci-fi', 'action-epic', 'noir-thriller'],
                'cast' => [
                    ['name' => 'Hikari Kusanagi', 'role' => 'cast', 'char' => 'Dr. Ren Aoi', 'order' => 1],
                    ['name' => 'Daiki Minamoto', 'role' => 'cast', 'char' => 'Commander Jin Kuroba', 'order' => 2],
                    ['name' => 'Elena Rostova', 'role' => 'cast', 'char' => 'Synthetica Prime', 'order' => 3],
                    ['name' => 'Kenjiro Takahashi', 'role' => 'director', 'char' => 'Director', 'order' => 4],
                ],
                'trailers' => [
                    ['title' => 'Official IMAX Theatrical Trailer', 'type' => 'official_trailer', 'duration' => 145, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'],
                ],
            ],

            // FEATURED HERO 2: Indonesian / Noir Thriller
            [
                'title' => 'Bayang-Bayang Batavia 1934',
                'original_title' => 'Batavia Shadows: The Jade Orchid Murders',
                'slug' => 'bayang-bayang-batavia-1934',
                'tagline' => 'Rahasia kelam di balik gemerlap marmer Menteng.',
                'synopsis' => 'Di tengah kemelut ekonomi dunia tahun 1934, pembunuhan berantai misterius mengguncang para bangsawan gula dan saudagar rempah di Kota Batavia. Seorang detektif pribumi eks-KNIL bekerja sama dengan jurnalis independen Belanda untuk membongkar konspirasi korupsi dan perdagangan opium yang mengalir hingga ke meja gubernur jenderal.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(5)->toDateString(),
                'runtime_minutes' => 132,
                'age_rating' => '17+',
                'audio_language_code' => 'id',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Raden Arya Wibisono',
                'studio_name' => 'Nusantara Heritage Cinema & Neon Noir',
                'country_of_origin' => 'Indonesia',
                'aspect_ratio' => '1.85:1 Flat',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 9.1,
                'critic_score' => 93,
                'poster_palette' => ['bg' => '#141118', 'accent' => '#F5C518', 'secondary' => '#991B1B', 'motif' => 'deco_geometric', 'icon' => 'eye'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1509281373149-e957c6296406?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'is_trending' => true,
                'featured_sort_order' => 2,
                'genres' => ['noir-thriller', 'drama', 'horror-mystery'],
                'cast' => [
                    ['name' => 'Reza Danuadji', 'role' => 'cast', 'char' => 'Detektif Surya Atmadja', 'order' => 1],
                    ['name' => 'Siti Annisa Putri', 'role' => 'cast', 'char' => 'Roro Gayatri', 'order' => 2],
                    ['name' => 'Pieter van Dijk', 'role' => 'cast', 'char' => 'Inspektur Willem', 'order' => 3],
                    ['name' => 'Raden Arya Wibisono', 'role' => 'director', 'char' => 'Director', 'order' => 4],
                ],
                'trailers' => [
                    ['title' => 'Teaser Perdana 4K Restorasi', 'type' => 'official_trailer', 'duration' => 128, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4'],
                ],
            ],

            // FEATURED HERO 3: English / Epic Drama
            [
                'title' => 'The Celestial Cartographer',
                'original_title' => null,
                'slug' => 'the-celestial-cartographer',
                'tagline' => 'Mapping the constellations that guide lost wanderers home.',
                'synopsis' => 'An eccentric Victorian astronomer and her deaf apprentice build a clockwork telescope inside a cliffside lighthouse, decoding an interstellar radio harmonic that predates human civilization. A sweeping meditation on wonder, isolation, and the transcendent language of mathematics.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(18)->toDateString(),
                'runtime_minutes' => 156,
                'age_rating' => 'PG-13',
                'audio_language_code' => 'en',
                'subtitle_languages_json' => ['id', 'fr'],
                'director_name' => 'Julian Vance',
                'studio_name' => 'Garnet Pictures & Searchlight',
                'country_of_origin' => 'United States',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => 'Dolby Atmos 128-ch',
                'audience_score' => 9.2,
                'critic_score' => 95,
                'poster_palette' => ['bg' => '#18141F', 'accent' => '#F5C518', 'secondary' => '#6366F1', 'motif' => 'deco_sunburst', 'icon' => 'masks-theater'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'is_trending' => false,
                'featured_sort_order' => 3,
                'genres' => ['drama', 'sci-fi', 'romance'],
                'cast' => [
                    ['name' => 'Claire Davenport', 'role' => 'cast', 'char' => 'Margaret Hallows', 'order' => 1],
                    ['name' => 'Thomas Sterling', 'role' => 'cast', 'char' => 'Arthur Finch', 'order' => 2],
                    ['name' => 'Julian Vance', 'role' => 'director', 'char' => 'Director', 'order' => 3],
                ],
                'trailers' => [
                    ['title' => 'Official Festival Trailer', 'type' => 'official_trailer', 'duration' => 150, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4'],
                ],
            ],

            // FEATURED HERO 4: Korean / Action Thriller
            [
                'title' => 'Seoul Phantom Protocol',
                'original_title' => '서울 유령 작전',
                'slug' => 'seoul-phantom-protocol',
                'tagline' => 'When your digital identity is erased, survival is your only weapon.',
                'synopsis' => 'A top counter-espionage operative waking up in a Han River safehouse discovers his biometric records, military clearance, and family records have been wiped clean in a national cyber blackout. He has six hours before the quarantine zone seals to hunt down the architect behind the phantom protocol.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(2)->toDateString(),
                'runtime_minutes' => 124,
                'age_rating' => '17+',
                'audio_language_code' => 'ko',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Park Chan-wook Studio',
                'studio_name' => 'CJ ENM & Matinee Premiere',
                'country_of_origin' => 'South Korea',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 8.9,
                'critic_score' => 91,
                'poster_palette' => ['bg' => '#111827', 'accent' => '#EF4444', 'secondary' => '#F5C518', 'motif' => 'deco_geometric', 'icon' => 'flame'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1514565131-fce0801e5785?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'is_trending' => true,
                'featured_sort_order' => 4,
                'genres' => ['action-epic', 'noir-thriller'],
                'cast' => [
                    ['name' => 'Lee Min-hyuk', 'role' => 'cast', 'char' => 'Agent Kang Tae-oh', 'order' => 1],
                    ['name' => 'Bae Doona', 'role' => 'cast', 'char' => 'Director Yoon', 'order' => 2],
                ],
                'trailers' => [
                    ['title' => 'Action Showcase Clip', 'type' => 'official_trailer', 'duration' => 110, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4'],
                ],
            ],

            // 5. French / Romance Drama (Trending)
            [
                'title' => 'L’Heure Bleue à Montmartre',
                'original_title' => 'The Blue Hour in Montmartre',
                'slug' => 'l-heure-bleue-a-montmartre',
                'tagline' => 'A fleeting tango between memory, cobblestones, and jazz.',
                'synopsis' => 'During a rainy autumn in 1958 Paris, an expatriate jazz pianist and an architectural conservator meet every dusk at an Art-Nouveau café. A poignant portrait of unspoken affection and the transient beauty of the twilight hour.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(8)->toDateString(),
                'runtime_minutes' => 112,
                'age_rating' => '13+',
                'audio_language_code' => 'fr',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Camille Laurent',
                'studio_name' => 'Pathé & Arte Cinema',
                'country_of_origin' => 'France',
                'aspect_ratio' => '1.66:1 European Standard',
                'sound_mix' => '7.1 Surround',
                'audience_score' => 9.0,
                'critic_score' => 94,
                'poster_palette' => ['bg' => '#1C1917', 'accent' => '#F472B6', 'secondary' => '#38BDF8', 'motif' => 'deco_sunburst', 'icon' => 'heart'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => true,
                'featured_sort_order' => 5,
                'genres' => ['romance', 'drama'],
                'cast' => [
                    ['name' => 'Antoine Delacroix', 'role' => 'cast', 'char' => 'Lucien Moreau', 'order' => 1],
                    ['name' => 'Juliette Binoche', 'role' => 'cast', 'char' => 'Mathilde Vane', 'order' => 2],
                ],
                'trailers' => [
                    ['title' => 'International Teaser', 'type' => 'official_trailer', 'duration' => 105, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4'],
                ],
            ],

            // 6. Animation / Japanese Fantasy (Trending)
            [
                'title' => 'Spirit of the Cedar Grove',
                'original_title' => '杉の杜の精霊',
                'slug' => 'spirit-of-the-cedar-grove',
                'tagline' => 'Listen to the whispers carved inside thousand-year rings.',
                'synopsis' => 'A young deaf woodcarver apprentice on Yakushima Island discovers that ancient cedar trees hold the preserved memories and lullabies of an extinct forest civilization. Hand-painted animated spectacle accompanied by traditional koto orchestration.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(20)->toDateString(),
                'runtime_minutes' => 118,
                'age_rating' => 'SU',
                'audio_language_code' => 'ja',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Makoto Shinkai Studio',
                'studio_name' => 'Studio Ghibli & CoMix Wave',
                'country_of_origin' => 'Japan',
                'aspect_ratio' => '1.85:1 Flat',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 9.5,
                'critic_score' => 97,
                'poster_palette' => ['bg' => '#064E3B', 'accent' => '#34D399', 'secondary' => '#F5C518', 'motif' => 'deco_sunburst', 'icon' => 'palette'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => true,
                'featured_sort_order' => 6,
                'genres' => ['animation', 'drama'],
                'cast' => [
                    ['name' => 'Aoi Miyazaki', 'role' => 'cast', 'char' => 'Kayo (Voice)', 'order' => 1],
                    ['name' => 'Ryunosuke Kamiki', 'role' => 'cast', 'char' => 'Ren (Voice)', 'order' => 2],
                ],
                'trailers' => [
                    ['title' => 'English Subtitled Trailer', 'type' => 'official_trailer', 'duration' => 130, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyBlazes.mp4'],
                ],
            ],

            // 7. Mandarin / Martial Arts Epic
            [
                'title' => 'The Jade Falcon Oath',
                'original_title' => '碧玉鷹誓',
                'slug' => 'the-jade-falcon-oath',
                'tagline' => 'Honor is forged across seven peaks of mist and blade.',
                'synopsis' => 'Set in the Wudang Mountains during the late Ming dynasty, a reclusive swordswoman must protect the sacred treaty seal from an imperial eunuch faction before the winter solstice eclipse.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(15)->toDateString(),
                'runtime_minutes' => 138,
                'age_rating' => '13+',
                'audio_language_code' => 'zh',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Zhang Yimou',
                'studio_name' => 'Beijing Film Studio',
                'country_of_origin' => 'China',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 8.8,
                'critic_score' => 90,
                'poster_palette' => ['bg' => '#0F172A', 'accent' => '#10B981', 'secondary' => '#F5C518', 'motif' => 'deco_geometric', 'icon' => 'flame'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1508739773434-c26b3d09e071?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => false,
                'featured_sort_order' => 7,
                'genres' => ['action-epic', 'drama'],
                'cast' => [
                    ['name' => 'Zhang Ziyi', 'role' => 'cast', 'char' => 'Master Lin Mei', 'order' => 1],
                    ['name' => 'Tony Leung', 'role' => 'cast', 'char' => 'Commander Huo', 'order' => 2],
                ],
                'trailers' => [
                    ['title' => 'Wuxia Action Teaser', 'type' => 'official_trailer', 'duration' => 120, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerMeltdowns.mp4'],
                ],
            ],

            // 8. Spanish / Horror Mystery
            [
                'title' => 'El Espejo de Sevilla',
                'original_title' => 'The Mirror of Seville',
                'slug' => 'el-espejo-de-sevilla',
                'tagline' => 'Some reflections are older than the cathedral itself.',
                'synopsis' => 'An antique mirror restorer in Andalusia uncovers a baroque mirror commissioned during the Spanish Inquisition that reveals spirits wandering the hallways of their ancestral convent.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(9)->toDateString(),
                'runtime_minutes' => 108,
                'age_rating' => '17+',
                'audio_language_code' => 'es',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Guillermo del Toro Presents',
                'studio_name' => 'El Deseo & Matinee Studios',
                'country_of_origin' => 'Spain',
                'aspect_ratio' => '1.85:1 Flat',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 8.7,
                'critic_score' => 89,
                'poster_palette' => ['bg' => '#2E1065', 'accent' => '#C084FC', 'secondary' => '#F5C518', 'motif' => 'deco_geometric', 'icon' => 'skull'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1514565131-fce0801e5785?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => true,
                'featured_sort_order' => 8,
                'genres' => ['horror-mystery', 'noir-thriller'],
                'cast' => [
                    ['name' => 'Penélope Cruz', 'role' => 'cast', 'char' => 'Clara Mendez', 'order' => 1],
                    ['name' => 'Javier Bardem', 'role' => 'cast', 'char' => 'Padre Ignacio', 'order' => 2],
                ],
                'trailers' => [
                    ['title' => 'Atmospheric Horror Clip', 'type' => 'official_trailer', 'duration' => 95, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4'],
                ],
            ],

            // 9. Indonesian / Drama Romance
            [
                'title' => 'Senja di Tepian Kali Progo',
                'original_title' => null,
                'slug' => 'senja-di-tepian-kali-progo',
                'tagline' => 'Ketika janji tertinggal di stasiun tua Yogyakarta.',
                'synopsis' => 'Kisah dua seniman batik di Kulon Progo yang berjuang mempertahankan motif pusaka keluarga di tengah gempuran pabrik tekstil modern dan pilihan hidup yang memisahkan mereka.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(6)->toDateString(),
                'runtime_minutes' => 115,
                'age_rating' => '13+',
                'audio_language_code' => 'id',
                'subtitle_languages_json' => ['en'],
                'director_name' => 'Hanung Bramantyo',
                'studio_name' => 'Dapur Film & Matinee',
                'country_of_origin' => 'Indonesia',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => '5.1 Surround',
                'audience_score' => 9.2,
                'critic_score' => 91,
                'poster_palette' => ['bg' => '#451A03', 'accent' => '#FBBF24', 'secondary' => '#F87171', 'motif' => 'deco_sunburst', 'icon' => 'heart'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => false,
                'featured_sort_order' => 9,
                'genres' => ['romance', 'drama'],
                'cast' => [
                    ['name' => 'Dian Sastrowardoyo', 'role' => 'cast', 'char' => 'Ratih Sekar', 'order' => 1],
                    ['name' => 'Nicholas Saputra', 'role' => 'cast', 'char' => 'Bagus Satrio', 'order' => 2],
                ],
                'trailers' => [
                    ['title' => 'Official Trailer Yogyakarta', 'type' => 'official_trailer', 'duration' => 115, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/SubaruOutbackSeeTheWorld.mp4'],
                ],
            ],

            // 10. English / Documentary & Music
            [
                'title' => 'Velvet Echoes: The 1931 Cinema Organs',
                'original_title' => null,
                'slug' => 'velvet-echoes-the-1931-cinema-organs',
                'tagline' => 'The thunderous machines that brought silent dreams to life.',
                'synopsis' => 'A visually stunning deep-dive documentary exploring the restoration of the legendary Wurlitzer and Mighty Barton pipe organs in American and European movie palaces.',
                'release_status' => 'now_showing',
                'release_date' => $today->copy()->subDays(25)->toDateString(),
                'runtime_minutes' => 96,
                'age_rating' => 'SU',
                'audio_language_code' => 'en',
                'subtitle_languages_json' => ['id'],
                'director_name' => 'Arthur Pendelton',
                'studio_name' => 'Criterion Archival & Matinee',
                'country_of_origin' => 'United Kingdom',
                'aspect_ratio' => '1.85:1 Flat',
                'sound_mix' => 'Dolby Atmos Mastered Audio',
                'audience_score' => 9.6,
                'critic_score' => 98,
                'poster_palette' => ['bg' => '#141118', 'accent' => '#F5C518', 'secondary' => '#10B981', 'motif' => 'deco_sunburst', 'icon' => 'music'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => false,
                'featured_sort_order' => 10,
                'genres' => ['documentary-music'],
                'cast' => [
                    ['name' => 'Dame Evelyn Glennie', 'role' => 'cast', 'char' => 'Narrator', 'order' => 1],
                ],
                'trailers' => [
                    ['title' => 'Audio Restoration Featurette', 'type' => 'official_trailer', 'duration' => 140, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4'],
                ],
            ],

            // COMING SOON 1 (Opens in 4 days)
            [
                'title' => 'The Whispering Gallery',
                'original_title' => null,
                'slug' => 'the-whispering-gallery',
                'tagline' => 'Every dome keeps an echo of what was murdered beneath it.',
                'synopsis' => 'An acoustic archaeologist surveying the restoration of London’s St. Paul’s Cathedral discovers that certain frequencies activate historical vocal recordings embedded directly into the micro-crystalline structure of the masonry.',
                'release_status' => 'coming_soon',
                'release_date' => $today->copy()->addDays(4)->toDateString(),
                'runtime_minutes' => 126,
                'age_rating' => '17+',
                'audio_language_code' => 'en',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Christopher Nolan Legacy',
                'studio_name' => 'Syncopy & Warner Bros',
                'country_of_origin' => 'United Kingdom',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => 'IMAX 12-Channel Immersion',
                'audience_score' => 0.0,
                'critic_score' => 92,
                'poster_palette' => ['bg' => '#0F172A', 'accent' => '#38BDF8', 'secondary' => '#F5C518', 'motif' => 'deco_geometric', 'icon' => 'sparkles'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => true,
                'featured_sort_order' => 11,
                'genres' => ['sci-fi', 'horror-mystery', 'noir-thriller'],
                'cast' => [
                    ['name' => 'Cillian Murphy', 'role' => 'cast', 'char' => 'Dr. Julian Thorne', 'order' => 1],
                    ['name' => 'Rebecca Ferguson', 'role' => 'cast', 'char' => 'Dr. Sarah Lin', 'order' => 2],
                ],
                'trailers' => [
                    ['title' => 'Premiere Teaser 4K', 'type' => 'official_trailer', 'duration' => 135, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/WeAreGoingOnBullrun.mp4'],
                ],
            ],

            // COMING SOON 2 (Opens in 10 days)
            [
                'title' => 'Gundala: Sang Penguasa Petir 2',
                'original_title' => null,
                'slug' => 'gundala-sang-penguasa-petir-2',
                'tagline' => 'Ketika langit ibu kota kembali bergemuruh menuntut keadilan.',
                'synopsis' => 'Sekuel epik Jagat Sinema Bumilangit. Sancaka menghadapi ancaman sindikat oligarki yang memanfaatkan rekayasa cuaca untuk menguasai sumber energi nasional.',
                'release_status' => 'coming_soon',
                'release_date' => $today->copy()->addDays(10)->toDateString(),
                'runtime_minutes' => 142,
                'age_rating' => '13+',
                'audio_language_code' => 'id',
                'subtitle_languages_json' => ['en'],
                'director_name' => 'Joko Anwar',
                'studio_name' => 'Bumilangit Studios & Screenplay',
                'country_of_origin' => 'Indonesia',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 0.0,
                'critic_score' => 88,
                'poster_palette' => ['bg' => '#18181B', 'accent' => '#F5C518', 'secondary' => '#3B82F6', 'motif' => 'deco_geometric', 'icon' => 'flame'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => true,
                'featured_sort_order' => 12,
                'genres' => ['action-epic', 'sci-fi'],
                'cast' => [
                    ['name' => 'Abimana Aryasatya', 'role' => 'cast', 'char' => 'Sancaka / Gundala', 'order' => 1],
                    ['name' => 'Tara Basro', 'role' => 'cast', 'char' => 'Wulan', 'order' => 2],
                ],
                'trailers' => [
                    ['title' => 'Official Bumilangit Teaser', 'type' => 'official_trailer', 'duration' => 120, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/WhatCarCanYouGetForAGrand.mp4'],
                ],
            ],

            // COMING SOON 3 (Opens in 18 days)
            [
                'title' => 'Kyoto Midnight Express',
                'original_title' => '京都深夜特急',
                'slug' => 'kyoto-midnight-express',
                'tagline' => 'A bullet train carrying passengers with no tickets back to dawn.',
                'synopsis' => 'On the final run of a decommissioned Shinkansen line through snowbound mountain passes, nine strangers realize that each tunnel they pass through strips away a year from their memories.',
                'release_status' => 'coming_soon',
                'release_date' => $today->copy()->addDays(18)->toDateString(),
                'runtime_minutes' => 120,
                'age_rating' => '13+',
                'audio_language_code' => 'ja',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Hirokazu Kore-eda',
                'studio_name' => 'Gaga & Matinee Premiere',
                'country_of_origin' => 'Japan',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 0.0,
                'critic_score' => 93,
                'poster_palette' => ['bg' => '#1E1B4B', 'accent' => '#818CF8', 'secondary' => '#F43F5E', 'motif' => 'deco_geometric', 'icon' => 'sparkles'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1503899036084-c55cdd92da26?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1542051841857-5f90071e7989?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => false,
                'featured_sort_order' => 13,
                'genres' => ['sci-fi', 'drama', 'noir-thriller'],
                'cast' => [
                    ['name' => 'Masaharu Fukuyama', 'role' => 'cast', 'char' => 'Kenzo', 'order' => 1],
                ],
                'trailers' => [
                    ['title' => 'First Look Teaser', 'type' => 'official_trailer', 'duration' => 100, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4'],
                ],
            ],

            // COMING SOON 4 (Opens in 26 days)
            [
                'title' => 'Le Masque d’Or (The Gilded Masque)',
                'original_title' => 'Le Masque d’Or',
                'slug' => 'le-masque-d-or',
                'tagline' => 'Behind every opera facade lies a duel of diamonds and arsenic.',
                'synopsis' => 'A lavish French period drama set in the Palais Garnier opera house in 1889 Paris during the Universal Exposition.',
                'release_status' => 'coming_soon',
                'release_date' => $today->copy()->addDays(26)->toDateString(),
                'runtime_minutes' => 134,
                'age_rating' => '17+',
                'audio_language_code' => 'fr',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Jacques Audiard',
                'studio_name' => 'Gaumont Cinema',
                'country_of_origin' => 'France',
                'aspect_ratio' => '1.85:1 Flat',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 0.0,
                'critic_score' => 90,
                'poster_palette' => ['bg' => '#141118', 'accent' => '#F5C518', 'secondary' => '#991B1B', 'motif' => 'deco_sunburst', 'icon' => 'masks-theater'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1507676184212-d03ab07a01bf?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => false,
                'featured_sort_order' => 14,
                'genres' => ['drama', 'romance'],
                'cast' => [
                    ['name' => 'Marion Cotillard', 'role' => 'cast', 'char' => 'Baronne Vivienne', 'order' => 1],
                ],
                'trailers' => [
                    ['title' => 'Cannes Teaser', 'type' => 'official_trailer', 'duration' => 110, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4'],
                ],
            ],

            // COMING SOON 5 (Opens in 34 days)
            [
                'title' => 'Busan Deep: Harbor of Shadows',
                'original_title' => '부산 심해',
                'slug' => 'busan-deep-harbor-of-shadows',
                'tagline' => 'The darkest crimes sink to the seafloor, but tides always return.',
                'synopsis' => 'A maritime insurance investigator in Busan uncovers a deep-sea salvage conspiracy involving sunken bullion and rogue naval contractors.',
                'release_status' => 'coming_soon',
                'release_date' => $today->copy()->addDays(34)->toDateString(),
                'runtime_minutes' => 128,
                'age_rating' => '17+',
                'audio_language_code' => 'ko',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Bong Joon-ho Associate',
                'studio_name' => 'Showbox Media',
                'country_of_origin' => 'South Korea',
                'aspect_ratio' => '2.39:1 Scope',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 0.0,
                'critic_score' => 91,
                'poster_palette' => ['bg' => '#0F172A', 'accent' => '#06B6D4', 'secondary' => '#F5C518', 'motif' => 'deco_geometric', 'icon' => 'flame'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => false,
                'featured_sort_order' => 15,
                'genres' => ['action-epic', 'noir-thriller'],
                'cast' => [
                    ['name' => 'Ma Dong-seok', 'role' => 'cast', 'char' => 'Captain Park', 'order' => 1],
                ],
                'trailers' => [
                    ['title' => 'Korean Action Teaser', 'type' => 'official_trailer', 'duration' => 115, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4'],
                ],
            ],

            // COMING SOON 6 (Opens in 42 days)
            [
                'title' => 'Rhapsody in Celluloid',
                'original_title' => null,
                'slug' => 'rhapsody-in-celluloid',
                'tagline' => 'A love letter to the nitrate film era that survived fire and forgotten vaults.',
                'synopsis' => 'An archival drama celebrating the projectionists, silent theater musicians, and hand-colorists of the 1920s cinema palaces.',
                'release_status' => 'coming_soon',
                'release_date' => $today->copy()->addDays(42)->toDateString(),
                'runtime_minutes' => 122,
                'age_rating' => 'PG-13',
                'audio_language_code' => 'en',
                'subtitle_languages_json' => ['en', 'id'],
                'director_name' => 'Damien Chazelle',
                'studio_name' => 'Paramount & Matinee Premiere',
                'country_of_origin' => 'United States',
                'aspect_ratio' => '1.33:1 Academy & 2.39:1 Scope',
                'sound_mix' => 'Dolby Atmos',
                'audience_score' => 0.0,
                'critic_score' => 95,
                'poster_palette' => ['bg' => '#141118', 'accent' => '#F5C518', 'secondary' => '#E11D48', 'motif' => 'deco_sunburst', 'icon' => 'masks-theater'],
                'poster_image_url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=800&auto=format&fit=crop&q=80',
                'backdrop_image_url' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=1600&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'is_trending' => false,
                'featured_sort_order' => 16,
                'genres' => ['drama', 'documentary-music'],
                'cast' => [
                    ['name' => 'Emma Stone', 'role' => 'cast', 'char' => 'Clara Bow Tribute', 'order' => 1],
                ],
                'trailers' => [
                    ['title' => 'Teaser Trailer', 'type' => 'official_trailer', 'duration' => 125, 'stream' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4'],
                ],
            ],
        ];

        foreach ($movies as $mData) {
            $genres = $mData['genres'];
            $cast = $mData['cast'];
            $trailers = $mData['trailers'];
            $palette = $mData['poster_palette'];

            unset($mData['genres'], $mData['cast'], $mData['trailers'], $mData['poster_palette']);
            $mData['poster_palette_json'] = $palette;

            $movie = Movie::updateOrCreate(['slug' => $mData['slug']], $mData);

            // Sync Genres
            $genreIds = Genre::whereIn('slug', $genres)->pluck('id');
            $movie->genres()->sync($genreIds);

            // Sync Credits
            $movie->credits()->delete();
            foreach ($cast as $c) {
                MovieCredit::create([
                    'movie_id' => $movie->id,
                    'person_name' => $c['name'],
                    'role_type' => $c['role'],
                    'character_or_job_title' => $c['char'],
                    'billing_order' => $c['order'],
                ]);
            }

            // Sync Trailers
            $movie->trailers()->delete();
            foreach ($trailers as $idx => $t) {
                MovieTrailer::create([
                    'movie_id' => $movie->id,
                    'title' => $t['title'],
                    'trailer_type' => $t['type'],
                    'duration_seconds' => $t['duration'],
                    'video_stream_url' => $t['stream'],
                    'is_primary' => $idx === 0,
                    'view_count' => rand(15, 340),
                ]);
            }
        }
    }
}
