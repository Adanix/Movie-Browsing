<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->char('currency_code', 3)->default('IDR');
            $table->decimal('base_price', 12, 2);
            $table->timestamps();
        });

        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->foreignId('cinema_id')->constrained('cinemas')->cascadeOnDelete();
            $table->foreignId('auditorium_id')->constrained('auditoriums')->cascadeOnDelete();
            $table->foreignId('pricing_tier_id')->nullable()->constrained('pricing_tiers')->nullOnDelete();
            $table->date('screening_date')->index();
            $table->dateTime('starts_at')->index();
            $table->dateTime('ends_at');
            $table->string('presentation_format', 60)->default('Standard Digital');
            $table->string('audio_language_code', 10)->nullable();
            $table->string('subtitle_language_code', 10)->nullable()->default('id');
            $table->boolean('is_captioned_cc')->default(false);
            $table->boolean('is_audio_described_ad')->default(false);
            $table->boolean('is_sensory_friendly_sf')->default(false);
            $table->boolean('is_parent_baby_pb')->default(false);
            $table->unsignedSmallInteger('available_seats_estimate')->default(140);
            $table->string('status', 30)->default('scheduled');
            $table->timestamps();

            $table->index(['cinema_id', 'screening_date', 'status']);
            $table->index(['movie_id', 'screening_date', 'cinema_id']);
            $table->index(['auditorium_id', 'starts_at', 'ends_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('showtimes');
        Schema::dropIfExists('pricing_tiers');
    }
};
