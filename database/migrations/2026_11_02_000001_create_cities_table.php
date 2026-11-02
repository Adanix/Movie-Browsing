<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('province_or_state', 100);
            $table->char('country_code', 2)->default('ID');
            $table->char('currency_code', 3)->default('IDR');
            $table->string('timezone', 64)->default('Asia/Jakarta');
            $table->decimal('center_latitude', 10, 7);
            $table->decimal('center_longitude', 10, 7);
            $table->string('tagline', 180)->nullable();
            $table->boolean('is_featured')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 40)->default('visitor_member')->index()->after('email');
            $table->string('persona_key', 50)->nullable()->unique()->after('role');
            $table->foreignId('preferred_city_id')->nullable()->after('persona_key')->constrained('cities')->nullOnDelete();
            $table->string('preferred_language_code', 10)->nullable()->default('en')->after('preferred_city_id');
            $table->boolean('is_demo_user')->default(false)->after('preferred_language_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['preferred_city_id']);
            $table->dropColumn(['role', 'persona_key', 'preferred_city_id', 'preferred_language_code', 'is_demo_user']);
        });

        Schema::dropIfExists('cities');
    }
};
