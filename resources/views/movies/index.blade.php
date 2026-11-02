<x-dynamic-component :component="'layouts.public'" title="Film Catalog & Screening Schedule — Matinee">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
         x-data="{
             viewMode: '{{ $currentView }}',
             filterDrawer: false,
         }">
        
        <!-- Catalog Header -->
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-4 pb-6 border-b border-velvet-border">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-bold tracking-wider">
                        Circuit Program
                    </span>
                    <span class="text-xs text-silver-screen/50">·</span>
                    <span class="text-xs font-mono text-silver-screen">
                        Screenings in <strong class="text-champagne">{{ $activeCity->name ?? 'Jakarta' }}</strong>
                    </span>
                </div>
                <h1 class="font-display font-black text-3xl sm:text-4xl text-champagne tracking-wide">
                    Theatrical Film Catalog
                </h1>
            </div>

            <!-- View Mode Switcher -->
            <div class="flex items-center gap-2">
                <span class="text-[11px] font-mono text-silver-screen/50 uppercase hidden sm:inline">Layout:</span>
                <div class="p-1 rounded-xl bg-velvet border border-velvet-border flex items-center gap-1 text-xs">
                    <button type="button" 
                            @click="viewMode = 'bento'"
                            :class="viewMode === 'bento' ? 'bg-velvet-raised text-marquee-gold border border-marquee-gold/40' : 'text-silver-screen hover:text-champagne'"
                            class="px-2.5 py-1.5 rounded-lg transition cursor-pointer flex items-center gap-1.5"
                            title="Editorial Bento Showcase">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/></svg>
                        <span class="hidden sm:inline">Bento</span>
                    </button>
                    <button type="button" 
                            @click="viewMode = 'grid'"
                            :class="viewMode === 'grid' ? 'bg-velvet-raised text-marquee-gold border border-marquee-gold/40' : 'text-silver-screen hover:text-champagne'"
                            class="px-2.5 py-1.5 rounded-lg transition cursor-pointer flex items-center gap-1.5"
                            title="3D Poster Wall">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span class="hidden sm:inline">3D Grid</span>
                    </button>
                    <button type="button" 
                            @click="viewMode = 'timeline'"
                            :class="viewMode === 'timeline' ? 'bg-velvet-raised text-marquee-gold border border-marquee-gold/40' : 'text-silver-screen hover:text-champagne'"
                            class="px-2.5 py-1.5 rounded-lg transition cursor-pointer flex items-center gap-1.5"
                            title="Marquee Schedule Timeline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <span class="hidden sm:inline">Timeline</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter & Search Dock -->
        <form method="GET" action="{{ route('movies.index') }}" class="my-6 space-y-4">
            <input type="hidden" name="view" :value="viewMode">

            <div class="p-4 sm:p-5 rounded-2xl bg-velvet border border-velvet-border space-y-4">
                
                <!-- Row 1: Search + Quick Category Tabs + Sort -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                    
                    <!-- Search Input -->
                    <div class="md:col-span-5 relative">
                        <svg class="w-4 h-4 text-silver-screen/50 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" 
                               name="q" 
                               value="{{ $filters['q'] ?? '' }}"
                               placeholder="Search film title, director, cast..."
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-obsidian border border-velvet-border focus:border-marquee-gold focus:outline-none text-champagne text-xs placeholder:text-silver-screen/40 transition">
                    </div>

                    <!-- Release Status Pills -->
                    <div class="md:col-span-4 flex items-center gap-1.5 text-xs">
                        <a href="{{ route('movies.index', array_merge($filters, ['release_status' => 'all'])) }}"
                           class="px-3 py-2 rounded-lg border transition {{ empty($filters['release_status']) || $filters['release_status'] === 'all' ? 'bg-marquee-gold text-obsidian font-bold border-marquee-gold' : 'bg-obsidian border-velvet-border text-silver-screen hover:text-champagne' }}">
                            All
                        </a>
                        <a href="{{ route('movies.index', array_merge($filters, ['release_status' => 'now_showing'])) }}"
                           class="px-3 py-2 rounded-lg border transition {{ ($filters['release_status'] ?? '') === 'now_showing' ? 'bg-marquee-gold text-obsidian font-bold border-marquee-gold' : 'bg-obsidian border-velvet-border text-silver-screen hover:text-champagne' }}">
                            Now Showing ({{ $totalNowShowing }})
                        </a>
                        <a href="{{ route('movies.index', array_merge($filters, ['release_status' => 'coming_soon'])) }}"
                           class="px-3 py-2 rounded-lg border transition {{ ($filters['release_status'] ?? '') === 'coming_soon' ? 'bg-marquee-gold text-obsidian font-bold border-marquee-gold' : 'bg-obsidian border-velvet-border text-silver-screen hover:text-champagne' }}">
                            Coming Soon ({{ $totalComingSoon }})
                        </a>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="md:col-span-3">
                        <select name="sort" 
                                onchange="this.form.submit()"
                                class="w-full py-2.5 px-3 rounded-xl bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs focus:outline-none transition cursor-pointer">
                            <option value="featured" {{ ($filters['sort'] ?? '') === 'featured' ? 'selected' : '' }}>Sort: Featured First</option>
                            <option value="trending" {{ ($filters['sort'] ?? '') === 'trending' ? 'selected' : '' }}>Sort: Trending Score</option>
                            <option value="release_desc" {{ ($filters['sort'] ?? '') === 'release_desc' ? 'selected' : '' }}>Sort: Newest Release</option>
                            <option value="release_asc" {{ ($filters['sort'] ?? '') === 'release_asc' ? 'selected' : '' }}>Sort: Oldest Release</option>
                            <option value="rating_desc" {{ ($filters['sort'] ?? '') === 'rating_desc' ? 'selected' : '' }}>Sort: Highest Rated</option>
                            <option value="title_asc" {{ ($filters['sort'] ?? '') === 'title_asc' ? 'selected' : '' }}>Sort: Title (A–Z)</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Faceted Selectors (Genre, Language, Release Date, Accessibility) -->
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3 pt-3 border-t border-velvet-border/80 text-xs">
                    <!-- Genre Selector -->
                    <div>
                        <label class="block text-[10px] font-mono uppercase text-silver-screen/60 mb-1">Genre</label>
                        <select name="genre" onchange="this.form.submit()" class="w-full py-2 px-2.5 rounded-lg bg-obsidian border border-velvet-border text-champagne focus:border-marquee-gold focus:outline-none">
                            <option value="">All Genres</option>
                            @foreach($genres as $g)
                                <option value="{{ $g->slug }}" {{ ($filters['genre'] ?? '') === $g->slug ? 'selected' : '' }}>{{ $g->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Language Selector -->
                    <div>
                        <label class="block text-[10px] font-mono uppercase text-silver-screen/60 mb-1">Spoken Language</label>
                        <select name="language" onchange="this.form.submit()" class="w-full py-2 px-2.5 rounded-lg bg-obsidian border border-velvet-border text-champagne focus:border-marquee-gold focus:outline-none">
                            <option value="">All Audio Languages</option>
                            @foreach($languages as $l)
                                <option value="{{ $l->code }}" {{ ($filters['language'] ?? '') === $l->code ? 'selected' : '' }}>{{ $l->name }} ({{ strtoupper($l->code) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Release Window Preset -->
                    <div>
                        <label class="block text-[10px] font-mono uppercase text-silver-screen/60 mb-1">Release Window</label>
                        <select name="release_window" onchange="this.form.submit()" class="w-full py-2 px-2.5 rounded-lg bg-obsidian border border-velvet-border text-champagne focus:border-marquee-gold focus:outline-none">
                            <option value="all">Any Release Window</option>
                            <option value="this_week" {{ ($filters['release_window'] ?? '') === 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ ($filters['release_window'] ?? '') === 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="next_month" {{ ($filters['release_window'] ?? '') === 'next_month' ? 'selected' : '' }}>Next Month</option>
                        </select>
                    </div>

                    <!-- Accessibility Tag -->
                    <div>
                        <label class="block text-[10px] font-mono uppercase text-silver-screen/60 mb-1">Accessibility</label>
                        <select name="accessibility" onchange="this.form.submit()" class="w-full py-2 px-2.5 rounded-lg bg-obsidian border border-velvet-border text-champagne focus:border-marquee-gold focus:outline-none">
                            <option value="">Any Format</option>
                            <option value="cc" {{ ($filters['accessibility'] ?? '') === 'cc' ? 'selected' : '' }}>CC (Captioned)</option>
                            <option value="ad" {{ ($filters['accessibility'] ?? '') === 'ad' ? 'selected' : '' }}>AD (Audio-Described)</option>
                            <option value="sf" {{ ($filters['accessibility'] ?? '') === 'sf' ? 'selected' : '' }}>SF (Sensory-Friendly)</option>
                            <option value="pb" {{ ($filters['accessibility'] ?? '') === 'pb' ? 'selected' : '' }}>PB (Parent & Baby)</option>
                        </select>
                    </div>

                    <!-- Submit / Reset Buttons -->
                    <div class="col-span-2 sm:col-span-4 lg:col-span-1 flex items-end gap-2">
                        <button type="submit" class="flex-1 py-2 rounded-lg bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs transition">
                            Filter
                        </button>
                        @if(array_filter($filters))
                            <a href="{{ route('movies.index') }}" class="py-2 px-3 rounded-lg bg-obsidian hover:bg-velvet-raised border border-velvet-border text-rose-alert text-xs transition" title="Clear Filters">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </form>

        <!-- Active Filter Pills (Removable) -->
        @if(array_filter($filters))
            <div class="flex flex-wrap items-center gap-2 mb-8 text-xs">
                <span class="text-silver-screen/50 font-mono text-[10px] uppercase">Active Filters:</span>
                @foreach($filters as $fKey => $fVal)
                    @if(filled($fVal) && !in_array($fKey, ['view', 'sort']))
                        <span class="px-2.5 py-1 rounded-full bg-marquee-gold/15 border border-marquee-gold/30 text-marquee-gold flex items-center gap-1.5 font-mono text-[11px]">
                            <span>{{ $fKey }}: {{ is_array($fVal) ? implode(',', $fVal) : $fVal }}</span>
                            <a href="{{ route('movies.index', array_diff_key($filters, [$fKey => ''])) }}" class="hover:text-champagne font-bold">×</a>
                        </span>
                    @endif
                @endforeach
                <a href="{{ route('movies.index') }}" class="text-xs text-silver-screen/60 hover:text-rose-alert underline ml-2">Clear all</a>
            </div>
        @endif

        <!-- Movie Catalog Grid / Bento / Timeline -->
        @if($movies->isNotEmpty())
            <div :class="{
                'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6': viewMode === 'bento',
                'grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-5': viewMode === 'grid',
                'space-y-4': viewMode === 'timeline'
            }">
                @foreach($movies as $idx => $movie)
                    <x-movie-card :movie="$movie" :viewMode="$currentView" :isBentoHero="$idx === 0 && empty($filters['q'])" x-bind:viewMode="viewMode" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $movies->links() }}
            </div>
        @else
            <!-- Themed Art-Deco Empty State -->
            <div class="rounded-3xl bg-velvet border border-velvet-border p-12 text-center space-y-4 my-10 max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-full bg-obsidian border border-marquee-gold/30 flex items-center justify-center text-marquee-gold mx-auto text-2xl">
                    🎞️
                </div>
                <h3 class="font-display font-bold text-xl text-champagne">
                    No Reels Match Your Criteria
                </h3>
                <p class="text-xs sm:text-sm text-silver-screen/70 leading-relaxed">
                    We could not find any films matching the specified genre, language, or release window in {{ $activeCity->name ?? 'Jakarta' }}.
                </p>
                <div class="pt-2">
                    <a href="{{ route('movies.index') }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs transition">
                        <span>Reset All Filters</span>
                    </a>
                </div>
            </div>
        @endif

    </div>

</x-dynamic-component>
