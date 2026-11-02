<?php

namespace App\Services\Catalog;

use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieCatalogQueryService
{
    public function query(array $filters = [], ?int $activeCityId = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Movie::query()->with([
            'genres',
            'audioLanguage',
            'primaryTrailer',
            'credits' => fn($q) => $q->where('role_type', 'cast')->take(3),
        ]);

        // Eager load showtimes scoped to active city today/upcoming
        if ($activeCityId) {
            $query->with(['showtimes' => function ($q) use ($activeCityId) {
                $q->whereHas('cinema', fn($c) => $c->where('city_id', $activeCityId))
                  ->where('screening_date', '>=', Carbon::today())
                  ->where('screening_date', '<=', Carbon::today()->addDays(7))
                  ->where('status', '!=', 'cancelled')
                  ->orderBy('starts_at')
                  ->take(6);
            }]);
        }

        // 1. Keyword search (q)
        if (!empty($filters['q'])) {
            $keyword = trim($filters['q']);
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('original_title', 'like', "%{$keyword}%")
                  ->orWhere('director_name', 'like', "%{$keyword}%")
                  ->orWhere('synopsis', 'like', "%{$keyword}%")
                  ->orWhereHas('credits', function (Builder $cq) use ($keyword) {
                      $cq->where('person_name', 'like', "%{$keyword}%");
                  });
            });
        }

        // 2. Genre filter (single or comma-separated / array)
        if (!empty($filters['genre'])) {
            $genres = is_array($filters['genre']) ? $filters['genre'] : explode(',', $filters['genre']);
            $genres = array_filter(array_map('trim', $genres));
            if (!empty($genres)) {
                $query->whereHas('genres', function (Builder $gq) use ($genres) {
                    $gq->whereIn('slug', $genres);
                });
            }
        }

        // 3. Audio Language filter
        if (!empty($filters['language']) && $filters['language'] !== 'all') {
            $query->where('audio_language_code', $filters['language']);
        }

        // 4. Subtitle Language filter
        if (!empty($filters['subtitle']) && $filters['subtitle'] !== 'all') {
            $query->whereJsonContains('subtitle_languages_json', $filters['subtitle']);
        }

        // 5. Release Status filter
        if (!empty($filters['release_status']) && $filters['release_status'] !== 'all') {
            $query->where('release_status', $filters['release_status']);
        }

        // 6. Release Window preset filter
        if (!empty($filters['release_window']) && $filters['release_window'] !== 'all') {
            $today = Carbon::today();
            switch ($filters['release_window']) {
                case 'this_week':
                    $query->whereBetween('release_date', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('release_date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()]);
                    break;
                case 'next_month':
                    $nextMonth = $today->copy()->addMonth();
                    $query->whereBetween('release_date', [$nextMonth->copy()->startOfMonth(), $nextMonth->copy()->endOfMonth()]);
                    break;
            }
        }

        // 7. Custom Release Date range
        if (!empty($filters['release_from']) && !empty($filters['release_to'])) {
            $query->whereBetween('release_date', [
                min($filters['release_from'], $filters['release_to']),
                max($filters['release_from'], $filters['release_to']),
            ]);
        } elseif (!empty($filters['release_from'])) {
            $query->where('release_date', '>=', $filters['release_from']);
        } elseif (!empty($filters['release_to'])) {
            $query->where('release_date', '<=', $filters['release_to']);
        }

        // 8. Screening Date filter (active city)
        if (!empty($filters['screening_date'])) {
            $sDate = $filters['screening_date'];
            $query->whereHas('showtimes', function (Builder $sq) use ($sDate, $activeCityId) {
                $sq->whereDate('screening_date', $sDate);
                if ($activeCityId) {
                    $sq->whereHas('cinema', fn($cq) => $cq->where('city_id', $activeCityId));
                }
            });
        }

        // 9. Accessibility filter (cc, ad, sf, pb)
        if (!empty($filters['accessibility'])) {
            $acc = strtolower(trim($filters['accessibility']));
            $columnMap = [
                'cc' => 'is_captioned_cc',
                'ad' => 'is_audio_described_ad',
                'sf' => 'is_sensory_friendly_sf',
                'pb' => 'is_parent_baby_pb',
            ];
            if (isset($columnMap[$acc])) {
                $col = $columnMap[$acc];
                $query->whereHas('showtimes', function (Builder $sq) use ($col, $activeCityId) {
                    $sq->where($col, true);
                    if ($activeCityId) {
                        $sq->whereHas('cinema', fn($cq) => $cq->where('city_id', $activeCityId));
                    }
                });
            }
        }

        // 10. Sorting
        $sort = $filters['sort'] ?? 'featured';
        switch ($sort) {
            case 'trending':
                $query->orderByDesc('is_trending')->orderByDesc('audience_score');
                break;
            case 'release_desc':
                $query->orderByDesc('release_date');
                break;
            case 'release_asc':
                $query->orderBy('release_date');
                break;
            case 'rating_desc':
                $query->orderByDesc('audience_score');
                break;
            case 'title_asc':
                $query->orderBy('title');
                break;
            case 'featured':
            default:
                $query->orderByDesc('is_featured')
                      ->orderBy('featured_sort_order')
                      ->orderByDesc('is_trending')
                      ->orderByDesc('release_date');
                break;
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
