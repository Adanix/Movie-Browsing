<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->string('code', 10)->primary();
            $table->string('name', 80);
            $table->string('native_name', 80)->nullable();
            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 80)->unique();
            $table->string('accent_color_hex', 20)->default('#F5C518');
            $table->string('icon_name', 60)->nullable();
            $table->timestamps();
        });

        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 180)->index();
            $table->string('original_title', 180)->nullable();
            $table->string('slug', 190)->unique();
            $table->string('tagline', 255)->nullable();
            $table->text('synopsis');
            $table->string('release_status', 30)->default('now_showing')->index();
            $table->date('release_date')->index();
            $table->unsignedSmallInteger('runtime_minutes');
            $table->string('age_rating', 20)->default('13+');
            $table->string('audio_language_code', 10)->index();
            $table->foreign('audio_language_code')->references('code')->on('languages');
            $table->json('subtitle_languages_json')->nullable();
            $table->string('director_name', 140)->nullable()->index();
            $table->string('studio_name', 140)->nullable();
            $table->string('country_of_origin', 80)->nullable();
            $table->string('aspect_ratio', 30)->default('2.39:1');
            $table->string('sound_mix', 60)->default('Dolby Atmos');
            $table->decimal('audience_score', 3, 1)->default(8.8);
            $table->unsignedTinyInteger('critic_score')->default(90);
            $table->json('poster_palette_json')->nullable();
            $table->string('poster_image_url', 255)->nullable();
            $table->string('backdrop_image_url', 255)->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_trending')->default(false)->index();
            $table->unsignedSmallInteger('featured_sort_order')->default(99);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['release_status', 'release_date', 'audio_language_code']);
        });

        Schema::create('movie_genre', function (Blueprint $table) {
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
            $table->primary(['movie_id', 'genre_id']);
        });

        Schema::create('movie_trailers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->string('title', 150);
            $table->string('trailer_type', 40)->default('official_trailer');
            $table->unsignedSmallInteger('duration_seconds')->default(135);
            $table->string('video_stream_url', 255)->nullable();
            $table->json('storyboard_config_json')->nullable();
            $table->boolean('is_primary')->default(true);
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();

            $table->index(['movie_id', 'is_primary']);
        });

        Schema::create('movie_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->string('person_name', 140)->index();
            $table->string('role_type', 40)->default('cast');
            $table->string('character_or_job_title', 140)->nullable();
            $table->unsignedTinyInteger('billing_order')->default(1);
            $table->timestamps();

            $table->index(['movie_id', 'role_type', 'billing_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_credits');
        Schema::dropIfExists('movie_trailers');
        Schema::dropIfExists('movie_genre');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('languages');
    }
};
