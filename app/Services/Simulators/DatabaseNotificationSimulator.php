<?php

namespace App\Services\Simulators;

use App\Contracts\NotificationProviderInterface;
use App\Models\User;
use App\Models\Movie;
use App\Models\City;
use App\Models\SimulatedNotificationLog;

class DatabaseNotificationSimulator implements NotificationProviderInterface
{
    public function dispatchReleaseReminder(User $user, Movie $movie, City $city): array
    {
        $subject = "🎟️ Opening Soon in {$city->name}: {$movie->title} at Matinee Cinemas";
        $body = "Dear {$user->name},\n\n" .
                "The film '{$movie->title}' is scheduled to open in {$city->name} on " . $movie->release_date->format('l, d F Y') . ".\n\n" .
                "Experience it at your nearest Matinee circuit cinema. Explore auditoriums and showtime schedules in your member portal.\n\n" .
                "— Matinee Premiere Network";

        $log = SimulatedNotificationLog::create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'city_id' => $city->id,
            'channel' => 'email',
            'recipient_email' => $user->email,
            'subject' => $subject,
            'message_body' => $body,
            'sent_at' => now(),
        ]);

        return [
            'id' => $log->id,
            'recipient' => $user->email,
            'subject' => $subject,
            'status' => 'simulated_delivered',
        ];
    }
}
