<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimulatedNotificationLog extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'city_id',
        'channel',
        'recipient_email',
        'subject',
        'message_body',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
