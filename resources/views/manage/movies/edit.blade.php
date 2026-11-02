@extends('layouts.manage', [
    'title' => 'Edit ' . $movie->title . ' — Matinee Cinema Platform'
])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Title -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-silver-screen/60 mb-1">
                <a href="{{ route('manage.movies.index') }}" class="hover:text-marquee-gold transition">Film Catalog</a>
                <span>/</span>
                <span class="text-champagne">{{ $movie->title }}</span>
            </div>
            <h1 class="font-display font-bold text-2xl text-champagne tracking-wide">Edit Film Metadata</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('movies.show', $movie->slug) }}" target="_blank" class="text-xs text-marquee-gold hover:underline flex items-center gap-1">
                <span>View Public Page</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            <span class="text-silver-screen/40">·</span>
            <a href="{{ route('manage.movies.index') }}" class="text-xs text-silver-screen hover:text-champagne transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back</span>
            </a>
        </div>
    </div>

    <!-- Error Summary Alert -->
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-alert/15 border border-rose-alert/40 text-rose-alert text-xs space-y-1">
            <div class="font-bold flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Please fix the following validation errors:</span>
            </div>
            <ul class="list-disc pl-5 space-y-0.5 text-silver-screen">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <form action="{{ route('manage.movies.update', $movie) }}" method="POST" class="rounded-xl bg-velvet border border-velvet-border p-6 shadow-2xl space-y-6">
        @csrf
        @method('PUT')

        <!-- Core Details -->
        <div>
            <h2 class="text-sm font-bold text-marquee-gold font-mono uppercase tracking-wider mb-4 border-b border-velvet-border pb-2">
                1. Core Film Metadata
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-silver-screen mb-1">Film Title <span class="text-rose-alert">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $movie->title) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold focus:ring-1 focus:ring-marquee-gold text-champagne text-xs transition">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Original Title</label>
                    <input type="text" name="original_title" value="{{ old('original_title', $movie->original_title) }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $movie->tagline) }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-silver-screen mb-1">Synopsis <span class="text-rose-alert">*</span></label>
                    <textarea name="synopsis" rows="4" required
                              class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs transition leading-relaxed">{{ old('synopsis', $movie->synopsis) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Theatrical Attributes -->
        <div>
            <h2 class="text-sm font-bold text-marquee-gold font-mono uppercase tracking-wider mb-4 border-b border-velvet-border pb-2">
                2. Scheduling & Theatrical Specifications
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Release Status <span class="text-rose-alert">*</span></label>
                    <select name="release_status" required
                            class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <option value="now_showing" {{ old('release_status', $movie->release_status) == 'now_showing' ? 'selected' : '' }}>Now Showing</option>
                        <option value="coming_soon" {{ old('release_status', $movie->release_status) == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                        <option value="archived" {{ old('release_status', $movie->release_status) == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Release Date <span class="text-rose-alert">*</span></label>
                    <input type="date" name="release_date" value="{{ old('release_date', $movie->release_date ? $movie->release_date->format('Y-m-d') : '') }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Runtime (Minutes) <span class="text-rose-alert">*</span></label>
                    <input type="number" name="runtime_minutes" value="{{ old('runtime_minutes', $movie->runtime_minutes) }}" min="30" max="360" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Age Rating <span class="text-rose-alert">*</span></label>
                    <select name="age_rating" required
                            class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <option value="SU" {{ old('age_rating', $movie->age_rating) == 'SU' ? 'selected' : '' }}>SU (Semua Umur / G)</option>
                        <option value="13+" {{ old('age_rating', $movie->age_rating) == '13+' ? 'selected' : '' }}>13+ (Remaja / PG-13)</option>
                        <option value="17+" {{ old('age_rating', $movie->age_rating) == '17+' ? 'selected' : '' }}>17+ (Dewasa / R)</option>
                        <option value="21+" {{ old('age_rating', $movie->age_rating) == '21+' ? 'selected' : '' }}>21+ (Dewasa Ekstrem)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Primary Audio <span class="text-rose-alert">*</span></label>
                    <select name="audio_language_code" required
                            class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        @foreach($languages as $lang)
                            <option value="{{ $lang->code }}" {{ old('audio_language_code', $movie->audio_language_code) == $lang->code ? 'selected' : '' }}>
                                {{ $lang->name }} ({{ strtoupper($lang->code) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Aspect Ratio</label>
                    <input type="text" name="aspect_ratio" value="{{ old('aspect_ratio', $movie->aspect_ratio) }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Director</label>
                    <input type="text" name="director_name" value="{{ old('director_name', $movie->director_name) }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Studio / Distributor</label>
                    <input type="text" name="studio_name" value="{{ old('studio_name', $movie->studio_name) }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Audience / Critic Score</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" step="0.1" name="audience_score" value="{{ old('audience_score', $movie->audience_score) }}" min="0" max="10"
                               class="w-full px-2 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <input type="number" name="critic_score" value="{{ old('critic_score', $movie->critic_score) }}" min="0" max="100"
                               class="w-full px-2 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                    </div>
                </div>
            </div>

            <!-- Genres Checkboxes -->
            <div class="mt-4">
                <label class="block text-xs font-medium text-silver-screen mb-2">Film Genres</label>
                @php
                    $currentGenreIds = $movie->genres->pluck('id')->toArray();
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    @foreach($genres as $genre)
                        <label class="flex items-center gap-2 p-2 rounded bg-obsidian border border-velvet-border hover:border-marquee-gold/40 cursor-pointer text-xs">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}" 
                                   {{ in_array($genre->id, old('genres', $currentGenreIds)) ? 'checked' : '' }}
                                   class="rounded bg-velvet border-velvet-border text-marquee-gold focus:ring-0">
                            <span class="text-champagne">{{ $genre->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Spotlight Toggles -->
            <div class="mt-4 flex flex-wrap gap-6 pt-2">
                <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-silver-screen">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $movie->is_featured) ? 'checked' : '' }}
                           class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                    <span>Feature on Homepage Hero Spotlight</span>
                </label>

                <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-silver-screen">
                    <input type="checkbox" name="is_trending" value="1" {{ old('is_trending', $movie->is_trending) ? 'checked' : '' }}
                           class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                    <span>Mark as Trending Now</span>
                </label>
            </div>
        </div>

        <!-- Media Assets -->
        <div>
            <h2 class="text-sm font-bold text-marquee-gold font-mono uppercase tracking-wider mb-4 border-b border-velvet-border pb-2">
                3. Poster Imagery & Artwork
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Poster Image URL (Vertical 2:3)</label>
                    <input type="url" name="poster_image_url" value="{{ old('poster_image_url', $movie->poster_image_url) }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                    @if($movie->poster_image_url)
                        <div class="mt-2 flex items-center gap-2">
                            <img src="{{ $movie->poster_image_url }}" alt="Poster" class="w-12 h-16 rounded object-cover border border-velvet-border">
                            <span class="text-[11px] text-silver-screen/50">Current poster preview</span>
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Backdrop Image URL (Landscape 16:9)</label>
                    <input type="url" name="backdrop_image_url" value="{{ old('backdrop_image_url', $movie->backdrop_image_url) }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                    @if($movie->backdrop_image_url)
                        <div class="mt-2 flex items-center gap-2">
                            <img src="{{ $movie->backdrop_image_url }}" alt="Backdrop" class="w-24 h-14 rounded object-cover border border-velvet-border">
                            <span class="text-[11px] text-silver-screen/50">Current backdrop preview</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-4 border-t border-velvet-border flex items-center justify-between">
            <a href="{{ route('manage.movies.index') }}" class="px-4 py-2 rounded-lg bg-obsidian border border-velvet-border text-silver-screen hover:text-champagne text-xs transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-marquee-gold text-obsidian font-bold text-xs hover:bg-amber-spotlight transition shadow-lg shadow-marquee-gold/20">
                Update Film
            </button>
        </div>

    </form>

</div>
@endsection
