<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cinemas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->foreignId('manager_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 150);
            $table->string('slug', 160)->unique();
            $table->string('neighborhood', 120);
            $table->string('address_line', 255);
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('phone_number', 40)->nullable();
            $table->text('transit_and_parking_note')->nullable();
            $table->json('opening_hours_json')->nullable();
            $table->json('amenities_json')->nullable();
            $table->string('architectural_style', 120)->nullable();
            $table->string('hero_badge', 80)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['city_id', 'is_active']);
        });

        Schema::create('auditoriums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cinema_id')->constrained('cinemas')->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('screen_format', 60)->default('Standard Digital');
            $table->string('sound_system', 60)->default('Dolby Atmos');
            $table->unsignedSmallInteger('total_capacity')->default(180);
            $table->unsignedTinyInteger('rows_count')->default(12);
            $table->unsignedTinyInteger('seats_per_row')->default(15);
            $table->boolean('is_step_free')->default(true);
            $table->timestamps();

            $table->index(['cinema_id', 'screen_format']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoriums');
        Schema::dropIfExists('cinemas');
    }
};
