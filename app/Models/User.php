<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'persona_key',
        'preferred_city_id',
        'preferred_language_code',
        'is_demo_user',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_demo_user' => 'boolean',
        ];
    }

    public function isMember(): bool
    {
        return $this->role === 'visitor_member';
    }

    public function isManager(): bool
    {
        return in_array($this->role, ['cinema_manager', 'platform_admin']);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'platform_admin';
    }

    public function preferredCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'preferred_city_id');
    }

    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    public function releaseReminders(): HasMany
    {
        return $this->hasMany(ReleaseReminder::class);
    }

    public function managedCinemas(): HasMany
    {
        return $this->hasMany(Cinema::class, 'manager_user_id');
    }
}
