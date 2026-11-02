<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Movie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'original_title',
        'slug',
        'tagline',
        'synopsis',
        'release_status',
        'release_date',
        'runtime_minutes',
        'age_rating',
        'audio_language_code',
        'subtitle_languages_json',
        'director_name',
        'studio_name',
        'country_of_origin',
        'aspect_ratio',
        'sound_mix',
        'audience_score',
        'critic_score',
        'poster_palette_json',
        'poster_image_url',
        'backdrop_image_url',
        'is_featured',
        'is_trending',
        'featured_sort_order',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'runtime_minutes' => 'integer',
            'audience_score' => 'float',
            'critic_score' => 'integer',
            'subtitle_languages_json' => 'array',
            'poster_palette_json' => 'array',
            'is_featured' => 'boolean',
            'is_trending' => 'boolean',
            'featured_sort_order' => 'integer',
        ];
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function audioLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'audio_language_code', 'code');
    }

    public function trailers(): HasMany
    {
        return $this->hasMany(MovieTrailer::class);
    }

    public function primaryTrailer(): HasOne
    {
        return $this->hasOne(MovieTrailer::class)->where('is_primary', true);
    }

    public function credits(): HasMany
    {
        return $this->hasMany(MovieCredit::class)->orderBy('billing_order');
    }

    public function castCredits(): HasMany
    {
        return $this->hasMany(MovieCredit::class)->where('role_type', 'cast')->orderBy('billing_order');
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }

    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    public function releaseReminders(): HasMany
    {
        return $this->hasMany(ReleaseReminder::class);
    }

    public function formattedRuntime(): string
    {
        $h = intdiv($this->runtime_minutes, 60);
        $m = $this->runtime_minutes % 60;
        return $h > 0 ? "{$h}h {$m}m" : "{$m}m";
    }

    public function scopeNowShowing(Builder $query): Builder
    {
        return $query->where('release_status', 'now_showing');
    }

    public function scopeComingSoon(Builder $query): Builder
    {
        return $query->where('release_status', 'coming_soon');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->orderBy('featured_sort_order');
    }

    public function scopeTrending(Builder $query): Builder
    {
        return $query->where('is_trending', true);
    }
}
