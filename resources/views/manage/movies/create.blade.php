@extends('layouts.manage', [
    'title' => 'Add New Film — Matinee Cinema Platform'
])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Title -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-silver-screen/60 mb-1">
                <a href="{{ route('manage.movies.index') }}" class="hover:text-marquee-gold transition">Film Catalog</a>
                <span>/</span>
                <span class="text-champagne">New Film Entry</span>
            </div>
            <h1 class="font-display font-bold text-2xl text-champagne tracking-wide">Add Film to Theatrical Catalog</h1>
        </div>
        <a href="{{ route('manage.movies.index') }}" class="text-xs text-silver-screen hover:text-champagne transition flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Back to list</span>
        </a>
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
    <form action="{{ route('manage.movies.store') }}" method="POST" class="rounded-xl bg-velvet border border-velvet-border p-6 shadow-2xl space-y-6">
        @csrf

        <!-- Core Details -->
        <div>
            <h2 class="text-sm font-bold text-marquee-gold font-mono uppercase tracking-wider mb-4 border-b border-velvet-border pb-2">
                1. Core Film Metadata
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-silver-screen mb-1">Film Title <span class="text-rose-alert">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold focus:ring-1 focus:ring-marquee-gold text-champagne text-xs transition"
                           placeholder="e.g. Metropolis: The 2026 Redux">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Original Title (Optional)</label>
                    <input type="text" name="original_title" value="{{ old('original_title') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs"
                           placeholder="e.g. Metropolis">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Tagline</label>
                    <input type="text" name="tagline" value="{{ old('tagline') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs"
                           placeholder="e.g. There can be no understanding between hand and brain without the heart.">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-silver-screen mb-1">Synopsis <span class="text-rose-alert">*</span></label>
                    <textarea name="synopsis" rows="4" required
                              class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs transition leading-relaxed"
                              placeholder="Full theatrical synopsis and plot summary...">{{ old('synopsis') }}</textarea>
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
                        <option value="now_showing" {{ old('release_status') == 'now_showing' ? 'selected' : '' }}>Now Showing</option>
                        <option value="coming_soon" {{ old('release_status') == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                        <option value="archived" {{ old('release_status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Release Date <span class="text-rose-alert">*</span></label>
                    <input type="date" name="release_date" value="{{ old('release_date', now()->format('Y-m-d')) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Runtime (Minutes) <span class="text-rose-alert">*</span></label>
                    <input type="number" name="runtime_minutes" value="{{ old('runtime_minutes', 120) }}" min="30" max="360" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Age Rating <span class="text-rose-alert">*</span></label>
                    <select name="age_rating" required
                            class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <option value="SU" {{ old('age_rating') == 'SU' ? 'selected' : '' }}>SU (Semua Umur / G)</option>
                        <option value="13+" {{ old('age_rating') == '13+' ? 'selected' : '' }}>13+ (Remaja / PG-13)</option>
                        <option value="17+" {{ old('age_rating', '17+') == '17+' ? 'selected' : '' }}>17+ (Dewasa / R)</option>
                        <option value="21+" {{ old('age_rating') == '21+' ? 'selected' : '' }}>21+ (Dewasa Ekstrem)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Primary Audio <span class="text-rose-alert">*</span></label>
                    <select name="audio_language_code" required
                            class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        @foreach($languages as $lang)
                            <option value="{{ $lang->code }}" {{ old('audio_language_code', 'en') == $lang->code ? 'selected' : '' }}>
                                {{ $lang->name }} ({{ strtoupper($lang->code) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Aspect Ratio</label>
                    <input type="text" name="aspect_ratio" value="{{ old('aspect_ratio', '2.39:1 Scope') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs"
                           placeholder="e.g. 2.39:1 Scope, 1.43:1 IMAX">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Director</label>
                    <input type="text" name="director_name" value="{{ old('director_name') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs"
                           placeholder="e.g. Christopher Nolan">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Studio / Distributor</label>
                    <input type="text" name="studio_name" value="{{ old('studio_name', 'Matinee Pictures') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Audience / Critic Score</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" step="0.1" name="audience_score" value="{{ old('audience_score', 8.5) }}" min="0" max="10" placeholder="Audience (0-10)"
                               class="w-full px-2 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <input type="number" name="critic_score" value="{{ old('critic_score', 88) }}" min="0" max="100" placeholder="Critic %"
                               class="w-full px-2 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                    </div>
                </div>
            </div>

            <!-- Genres Checkboxes -->
            <div class="mt-4">
                <label class="block text-xs font-medium text-silver-screen mb-2">Film Genres</label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    @foreach($genres as $genre)
                        <label class="flex items-center gap-2 p-2 rounded bg-obsidian border border-velvet-border hover:border-marquee-gold/40 cursor-pointer text-xs">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}" 
                                   {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}
                                   class="rounded bg-velvet border-velvet-border text-marquee-gold focus:ring-0">
                            <span class="text-champagne">{{ $genre->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Spotlight Toggles -->
            <div class="mt-4 flex flex-wrap gap-6 pt-2">
                <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-silver-screen">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                           class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                    <span>Feature on Homepage Hero Spotlight</span>
                </label>

                <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-silver-screen">
                    <input type="checkbox" name="is_trending" value="1" {{ old('is_trending') ? 'checked' : '' }}
                           class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                    <span>Mark as Trending Now</span>
                </label>
            </div>
        </div>

        <!-- Media Assets & Theatrical Trailer -->
        <div>
            <h2 class="text-sm font-bold text-marquee-gold font-mono uppercase tracking-wider mb-4 border-b border-velvet-border pb-2">
                3. Poster Imagery & Streamable Trailer
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Poster Image URL (Vertical 2:3)</label>
                    <input type="url" name="poster_image_url" value="{{ old('poster_image_url') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs"
                           placeholder="https://images.unsplash.com/...">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Backdrop Image URL (Landscape 16:9)</label>
                    <input type="url" name="backdrop_image_url" value="{{ old('backdrop_image_url') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs"
                           placeholder="https://images.unsplash.com/...">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Trailer Title</label>
                    <input type="text" name="trailer_title" value="{{ old('trailer_title', 'Official Theatrical Trailer') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Trailer Video Stream URL (HLS / MP4)</label>
                    <input type="url" name="video_stream_url" value="{{ old('video_stream_url', 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4') }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-4 border-t border-velvet-border flex items-center justify-end gap-3">
            <a href="{{ route('manage.movies.index') }}" class="px-4 py-2 rounded-lg bg-obsidian border border-velvet-border text-silver-screen hover:text-champagne text-xs transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-marquee-gold text-obsidian font-bold text-xs hover:bg-amber-spotlight transition shadow-lg shadow-marquee-gold/20">
                Save & Publish Film
            </button>
        </div>

    </form>

</div>
@endsection
