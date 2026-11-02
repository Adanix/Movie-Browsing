<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watchlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->string('notes', 255)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'movie_id']);
        });

        Schema::create('release_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->string('status', 30)->default('subscribed');
            $table->dateTime('notified_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'movie_id', 'city_id']);
        });

        Schema::create('external_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source', 100);
            $table->string('status', 30);
            $table->text('summary');
            $table->json('payload_json')->nullable();
            $table->timestamps();
        });

        Schema::create('simulated_notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->string('channel', 30)->default('email');
            $table->string('recipient_email', 160);
            $table->string('subject', 255);
            $table->text('message_body');
            $table->dateTime('sent_at');
            $table->timestamps();

            $table->index(['user_id', 'sent_at']);
        });

        Schema::create('demo_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('persona_key', 50)->nullable();
            $table->string('event_type', 60);
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('payload_json')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_activity_logs');
        Schema::dropIfExists('simulated_notification_logs');
        Schema::dropIfExists('external_sync_logs');
        Schema::dropIfExists('release_reminders');
        Schema::dropIfExists('watchlists');
    }
};
