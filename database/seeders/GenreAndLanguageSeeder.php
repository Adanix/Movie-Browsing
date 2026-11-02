<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
use App\Models\Language;

class GenreAndLanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English'],
            ['code' => 'id', 'name' => 'Indonesian', 'native_name' => 'Bahasa Indonesia'],
            ['code' => 'ja', 'name' => 'Japanese', 'native_name' => '日本語'],
            ['code' => 'ko', 'name' => 'Korean', 'native_name' => '한국어'],
            ['code' => 'fr', 'name' => 'French', 'native_name' => 'Français'],
            ['code' => 'zh', 'name' => 'Mandarin', 'native_name' => '中文'],
            ['code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español'],
        ];

        foreach ($languages as $l) {
            Language::updateOrCreate(['code' => $l['code']], $l);
        }

        $genres = [
            ['name' => 'Sci-Fi', 'slug' => 'sci-fi', 'accent_color_hex' => '#38BDF8', 'icon_name' => 'sparkles'],
            ['name' => 'Noir & Thriller', 'slug' => 'noir-thriller', 'accent_color_hex' => '#F5C518', 'icon_name' => 'eye'],
            ['name' => 'Drama', 'slug' => 'drama', 'accent_color_hex' => '#FB7185', 'icon_name' => 'masks-theater'],
            ['name' => 'Animation', 'slug' => 'animation', 'accent_color_hex' => '#F472B6', 'icon_name' => 'palette'],
            ['name' => 'Horror & Mystery', 'slug' => 'horror-mystery', 'accent_color_hex' => '#A855F7', 'icon_name' => 'skull'],
            ['name' => 'Action & Epic', 'slug' => 'action-epic', 'accent_color_hex' => '#F97316', 'icon_name' => 'flame'],
            ['name' => 'Romance', 'slug' => 'romance', 'accent_color_hex' => '#EC4899', 'icon_name' => 'heart'],
            ['name' => 'Documentary & Music', 'slug' => 'documentary-music', 'accent_color_hex' => '#10B981', 'icon_name' => 'music'],
        ];

        foreach ($genres as $g) {
            Genre::updateOrCreate(['slug' => $g['slug']], $g);
        }
    }
}
