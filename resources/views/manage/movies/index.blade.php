@extends('layouts.manage', [
    'title' => 'Manage Films Catalog — Matinee Cinema Platform'
])

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-display font-bold text-2xl text-champagne tracking-wide">Film Catalog Master</h1>
            <p class="text-silver-screen/70 text-xs mt-1">
                Curate theatrical titles, synopsis, aspect ratios, localized metadata, and trailers.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manage.movies.create') }}" 
               class="px-4 py-2 rounded-lg bg-marquee-gold text-obsidian font-bold text-xs hover:bg-amber-spotlight transition inline-flex items-center gap-1.5 shadow-lg shadow-marquee-gold/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add New Film</span>
            </a>
        </div>
    </div>

    <!-- Movie Table Card -->
    <div class="rounded-xl bg-velvet border border-velvet-border overflow-hidden shadow-2xl">
        <div class="p-4 border-b border-velvet-border flex items-center justify-between text-xs">
            <span class="font-mono text-silver-screen/60">Total Films: {{ $movies->total() }}</span>
            <span class="text-silver-screen/50 text-[11px]">Platform Curator Access Only</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs divide-y divide-velvet-border">
                <thead class="bg-obsidian/60 text-silver-screen/70 font-mono text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Film</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3">Rating & Time</th>
                        <th class="py-3 px-3">Genres</th>
                        <th class="py-3 px-3">Scores</th>
                        <th class="py-3 px-3">Release Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-velvet-border">
                    @forelse($movies as $movie)
                        <tr class="hover:bg-velvet-raised/50 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-14 rounded overflow-hidden bg-obsidian flex-shrink-0 border border-velvet-border">
                                        @if($movie->poster_image_url)
                                            <img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-[10px] text-silver-screen/40 font-mono">POSTER</div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('movies.show', $movie->slug) }}" target="_blank" class="font-bold text-champagne hover:text-marquee-gold transition flex items-center gap-1">
                                            <span>{{ $movie->title }}</span>
                                            <svg class="w-3 h-3 text-silver-screen/40 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                        <div class="text-[11px] text-silver-screen/50 mt-0.5">
                                            {{ $movie->original_title ? $movie->original_title . ' · ' : '' }}Dir: {{ $movie->director_name ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                @if($movie->release_status === 'now_showing')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-open/15 text-emerald-open text-[10px] font-mono font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-open"></span> Now Showing
                                    </span>
                                @elseif($movie->release_status === 'coming_soon')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-sky-upcoming/15 text-sky-upcoming text-[10px] font-mono font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-upcoming"></span> Coming Soon
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-silver-screen/15 text-silver-screen text-[10px] font-mono font-medium">
                                        Archived
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                <div class="text-champagne font-mono font-semibold">{{ $movie->age_rating }}</div>
                                <div class="text-silver-screen/60 text-[11px]">{{ $movie->runtime_minutes }} min</div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="flex flex-wrap gap-1 max-w-[180px]">
                                    @foreach($movie->genres as $genre)
                                        <span class="px-1.5 py-0.5 rounded bg-obsidian text-silver-screen/80 text-[10px] border border-velvet-border">
                                            {{ $genre->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                <div class="flex items-center gap-2 font-mono text-[11px]">
                                    <span class="text-marquee-gold font-bold">★ {{ number_format($movie->audience_score, 1) }}</span>
                                    <span class="text-silver-screen/50">|</span>
                                    <span class="text-silver-screen/80">{{ $movie->critic_score }}%</span>
                                </div>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap text-silver-screen/70 font-mono text-[11px]">
                                {{ $movie->release_date ? $movie->release_date->format('d M Y') : '—' }}
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('manage.movies.edit', $movie) }}" 
                                       class="p-1.5 rounded bg-velvet-raised hover:bg-velvet border border-velvet-border text-silver-screen hover:text-champagne transition"
                                       title="Edit Film">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <form action="{{ route('manage.movies.destroy', $movie) }}" method="POST" onsubmit="return confirm('Archive \'{{ addslashes($movie->title) }}\' from active catalog?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-1.5 rounded bg-velvet-raised hover:bg-rose-alert/20 border border-velvet-border text-silver-screen hover:text-rose-alert transition"
                                                title="Archive Film">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-silver-screen/50">
                                No movies found in the catalog. Click "Add New Film" to curate one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($movies->hasPages())
            <div class="p-4 border-t border-velvet-border bg-obsidian/30">
                {{ $movies->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
