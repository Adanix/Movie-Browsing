<x-dynamic-component :component="'layouts.public'" title="Matinee — Multi-City Cinema Browsing & Animated Catalog">

    <!-- 1. Hero Marquee Stage with Live Countdown -->
    <section class="relative bg-obsidian border-b border-velvet-border overflow-hidden pt-4 pb-16 lg:pb-24">
        <!-- Ambient Art-Deco Background Glows -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[800px] h-[350px] bg-crimson-curtain/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 -right-20 w-96 h-96 bg-marquee-gold/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Marquee Announcement Ticker -->
            <div class="mb-6 py-2 px-4 rounded-xl bg-velvet border border-marquee-gold/20 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-marquee-gold animate-pulse"></span>
                    <span class="font-mono text-marquee-gold uppercase font-bold tracking-wider">Tonight's Circuit Marquee</span>
                    <span class="hidden sm:inline text-silver-screen/40">·</span>
                    <span class="hidden sm:inline text-champagne">Now Screening across {{ $allCities->count() }} Cities in the Matinee Premiere Network</span>
                </div>
                <div class="flex items-center gap-3 font-mono text-[11px]">
                    <span class="text-silver-screen/70">City: <strong class="text-marquee-gold">{{ $activeCity->name ?? 'Jakarta' }}</strong></span>
                    <button type="button" @click="cityModal = true" class="text-silver-screen hover:text-champagne underline underline-offset-2">Change</button>
                </div>
            </div>

            <!-- Featured Film Hero Stage (Takes First Featured Movie) -->
            @php $hero = $featuredMovies->first(); @endphp
            @if($hero)
                <div class="rounded-3xl bg-velvet border border-marquee-gold/30 overflow-hidden relative shadow-2xl">
                    <!-- Hero Backdrop Image -->
                    <div class="absolute inset-0 bg-cover bg-center opacity-30 sm:opacity-40" 
                         style="background-image: url('{{ $hero->backdrop_image_url ?: $hero->poster_image_url }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-obsidian via-obsidian/70 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-obsidian via-obsidian/80 to-transparent"></div>

                    <!-- Stage Content -->
                    <div class="relative p-6 sm:p-10 lg:p-14 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        
                        <!-- Left: Illuminated Typography & Details -->
                        <div class="lg:col-span-7 space-y-5">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-3 py-1 rounded-full bg-marquee-gold/20 text-marquee-gold border border-marquee-gold/40 text-xs font-mono font-bold tracking-widest uppercase">
                                    ★ Featured Premiere
                                </span>
                                <span class="px-2.5 py-1 rounded bg-obsidian/80 text-champagne text-xs font-mono border border-velvet-border">
                                    {{ strtoupper($hero->audio_language_code) }} AUDIO · {{ implode('/', $hero->subtitle_languages_json ?? ['EN']) }} SUB
                                </span>
                                <span class="px-2 py-1 rounded bg-obsidian/80 text-silver-screen text-xs font-mono border border-velvet-border">
                                    {{ $hero->age_rating }}
                                </span>
                            </div>

                            <h1 class="font-display font-black text-3xl sm:text-5xl lg:text-6xl text-champagne leading-tight tracking-wide marquee-glow">
                                {{ $hero->title }}
                            </h1>

                            <div class="text-sm sm:text-base font-display text-marquee-gold italic font-medium">
                                "{{ $hero->tagline ?: 'A landmark theatrical experience in the Matinee Circuit.' }}"
                            </div>

                            <p class="text-xs sm:text-sm text-silver-screen/90 leading-relaxed max-w-xl">
                                {{ $hero->synopsis }}
                            </p>

                            <!-- Hero CTAs -->
                            <div class="pt-3 flex flex-wrap items-center gap-3">
                                <button type="button" 
                                        @click="$store.trailerModal.open('{{ $hero->slug }}')"
                                        class="px-6 py-3.5 rounded-xl bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-sm tracking-wide transition shadow-lg flex items-center gap-2 cursor-pointer">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <span>Watch Official Trailer</span>
                                </button>

                                <a href="{{ route('movies.show', $hero) }}" 
                                   class="px-6 py-3.5 rounded-xl bg-velvet-raised hover:bg-velvet border border-marquee-gold/40 hover:border-marquee-gold text-champagne font-semibold text-sm transition flex items-center gap-2">
                                    <span>View Showtimes</span>
                                    <span>→</span>
                                </a>

                                <button type="button" 
                                        @click="$store.watchlist.toggle({{ $hero->id }})"
                                        class="p-3.5 rounded-xl bg-velvet border border-velvet-border hover:border-marquee-gold/40 text-silver-screen hover:text-marquee-gold transition"
                                        title="Add to Watchlist">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Right: Live Screening Countdown Box + 3D Poster -->
                        <div class="lg:col-span-5 flex flex-col items-center lg:items-end gap-5">
                            <!-- Countdown Box to Next Screening -->
                            @if($nextScreening)
                                <div class="w-full max-w-sm rounded-2xl bg-obsidian/90 border border-marquee-gold/30 p-5 shadow-2xl backdrop-blur-md"
                                     x-data="screeningCountdown('{{ $nextScreening->starts_at->toIso8601String() }}')">
                                    <div class="flex items-center justify-between text-[11px] font-mono uppercase tracking-wider text-silver-screen/70 pb-3 border-b border-velvet-border">
                                        <span class="flex items-center gap-1.5 text-marquee-gold font-bold">
                                            <span class="w-2 h-2 rounded-full bg-marquee-gold animate-ping"></span>
                                            Next Screening in {{ $activeCity->name ?? 'Jakarta' }}
                                        </span>
                                        <span>{{ $nextScreening->formattedTime() }}</span>
                                    </div>

                                    <div class="grid grid-cols-3 gap-2 text-center my-3">
                                        <div class="p-2 rounded-lg bg-velvet border border-velvet-border">
                                            <div class="font-mono text-xl sm:text-2xl font-bold text-champagne" x-text="hours">00</div>
                                            <div class="text-[9px] font-mono uppercase text-silver-screen/60">Hours</div>
                                        </div>
                                        <div class="p-2 rounded-lg bg-velvet border border-velvet-border">
                                            <div class="font-mono text-xl sm:text-2xl font-bold text-champagne" x-text="minutes">00</div>
                                            <div class="text-[9px] font-mono uppercase text-silver-screen/60">Mins</div>
                                        </div>
                                        <div class="p-2 rounded-lg bg-velvet border border-velvet-border">
                                            <div class="font-mono text-xl sm:text-2xl font-bold text-marquee-gold" x-text="seconds">00</div>
                                            <div class="text-[9px] font-mono uppercase text-silver-screen/60">Secs</div>
                                        </div>
                                    </div>

                                    <div class="text-xs text-silver-screen/80 pt-2 border-t border-velvet-border flex items-center justify-between">
                                        <span class="truncate">{{ $nextScreening->cinema->name }}</span>
                                        <button type="button" 
                                                @click="$store.showtimeDrawer.open({{ $nextScreening->id }})"
                                                class="text-marquee-gold hover:underline font-mono text-[11px] font-bold">
                                            Reserve Slot →
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <!-- Mini Carousel Switcher for Other Featured Films -->
                            <div class="flex items-center gap-3">
                                @foreach($featuredMovies as $fIdx => $fFilm)
                                    <a href="{{ route('movies.show', $fFilm) }}" 
                                       class="group w-14 h-20 rounded-lg overflow-hidden border transition relative {{ $fFilm->id === $hero->id ? 'border-marquee-gold ring-2 ring-marquee-gold/30' : 'border-velvet-border opacity-60 hover:opacity-100 hover:border-marquee-gold/50' }}">
                                        @if($fFilm->poster_image_url)
                                            <img src="{{ $fFilm->poster_image_url }}" alt="{{ $fFilm->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-velvet flex items-center justify-center text-[9px] font-mono text-marquee-gold">
                                                #{{ $fIdx + 1 }}
                                            </div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </section>

    <!-- 2. Interactive Animated Movie Catalog Showcase ("Ga Kaku, Full Animasi") -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20"
             x-data="{ 
                 activeTab: 'trending',
                 layoutMode: 'bento'
             }">
        
        <!-- Showcase Header & Controls Dock -->
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 pb-8 border-b border-velvet-border">
            <div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-semibold tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-marquee-gold"></span>
                    Fluid Catalog Explorer
                </span>
                <h2 class="font-display font-black text-2xl sm:text-4xl text-champagne mt-2 tracking-wide">
                    Featured & Trending Titles
                </h2>
                <p class="text-xs sm:text-sm text-silver-screen/80 mt-1">
                    Kinetic catalog with 3D perspective physics, cursor glare, and instant city showtime lookup.
                </p>
            </div>

            <!-- Tab Switcher & View Mode Toggles -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Category Tabs -->
                <div class="p-1 rounded-xl bg-velvet border border-velvet-border flex items-center gap-1 text-xs font-medium">
                    <button type="button" 
                            @click="activeTab = 'trending'"
                            :class="activeTab === 'trending' ? 'bg-marquee-gold text-obsidian font-bold shadow-md' : 'text-silver-screen hover:text-champagne'"
                            class="px-3 py-1.5 rounded-lg transition cursor-pointer">
                        Trending Now
                    </button>
                    <button type="button" 
                            @click="activeTab = 'now_showing'"
                            :class="activeTab === 'now_showing' ? 'bg-marquee-gold text-obsidian font-bold shadow-md' : 'text-silver-screen hover:text-champagne'"
                            class="px-3 py-1.5 rounded-lg transition cursor-pointer">
                        Now Showing
                    </button>
                    <button type="button" 
                            @click="activeTab = 'coming_soon'"
                            :class="activeTab === 'coming_soon' ? 'bg-marquee-gold text-obsidian font-bold shadow-md' : 'text-silver-screen hover:text-champagne'"
                            class="px-3 py-1.5 rounded-lg transition cursor-pointer">
                        Coming Soon
                    </button>
                </div>

                <!-- 3 Non-Rigid Layout Switchers (Mode A Bento, Mode B 3D Grid, Mode C Timeline) -->
                <div class="p-1 rounded-xl bg-velvet border border-velvet-border flex items-center gap-1 text-xs">
                    <button type="button" 
                            @click="layoutMode = 'bento'"
                            :class="layoutMode === 'bento' ? 'bg-velvet-raised text-marquee-gold border border-marquee-gold/40' : 'text-silver-screen hover:text-champagne'"
                            class="p-2 rounded-lg transition cursor-pointer"
                            title="Editorial Bento Showcase (Default)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/></svg>
                    </button>
                    <button type="button" 
                            @click="layoutMode = 'grid'"
                            :class="layoutMode === 'grid' ? 'bg-velvet-raised text-marquee-gold border border-marquee-gold/40' : 'text-silver-screen hover:text-champagne'"
                            class="p-2 rounded-lg transition cursor-pointer"
                            title="3D Poster Grid">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </button>
                    <button type="button" 
                            @click="layoutMode = 'timeline'"
                            :class="layoutMode === 'timeline' ? 'bg-velvet-raised text-marquee-gold border border-marquee-gold/40' : 'text-silver-screen hover:text-champagne'"
                            class="p-2 rounded-lg transition cursor-pointer"
                            title="Marquee Schedule Timeline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Filter Category Bar -->
        <div class="py-4 flex flex-wrap items-center justify-between gap-3 text-xs border-b border-velvet-border/50 mb-8">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                <span class="text-silver-screen/50 uppercase font-mono text-[10px] mr-1">Quick Genre:</span>
                @foreach($genres->take(6) as $g)
                    <a href="{{ route('movies.index', ['genre' => $g->slug]) }}" 
                       class="px-2.5 py-1 rounded-full bg-velvet hover:bg-velvet-raised border border-velvet-border hover:border-marquee-gold/40 text-silver-screen hover:text-champagne transition whitespace-nowrap">
                        {{ $g->name }}
                    </a>
                @endforeach
            </div>

            <a href="{{ route('movies.index') }}" class="text-marquee-gold hover:text-champagne font-mono font-medium flex items-center gap-1 transition">
                <span>Open Full Catalog & Filters</span>
                <span>→</span>
            </a>
        </div>

        <!-- TAB 1: Trending Now -->
        <div x-show="activeTab === 'trending'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0">
            <div :class="{
                'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6': layoutMode === 'bento',
                'grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-5': layoutMode === 'grid',
                'space-y-4': layoutMode === 'timeline'
            }">
                @foreach($trendingMovies as $idx => $movie)
                    <x-movie-card :movie="$movie" :viewMode="'grid'" :isBentoHero="$idx === 0" x-bind:viewMode="layoutMode" />
                @endforeach
            </div>
        </div>

        <!-- TAB 2: Now Showing -->
        <div x-show="activeTab === 'now_showing'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            <div :class="{
                'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6': layoutMode === 'bento',
                'grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-5': layoutMode === 'grid',
                'space-y-4': layoutMode === 'timeline'
            }">
                @foreach($nowShowingMovies as $idx => $movie)
                    <x-movie-card :movie="$movie" :viewMode="'grid'" :isBentoHero="$idx === 1" x-bind:viewMode="layoutMode" />
                @endforeach
            </div>
        </div>

        <!-- TAB 3: Coming Soon -->
        <div x-show="activeTab === 'coming_soon'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
            <div :class="{
                'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6': layoutMode === 'bento',
                'grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-5': layoutMode === 'grid',
                'space-y-4': layoutMode === 'timeline'
            }">
                @foreach($comingSoonMovies as $idx => $movie)
                    <x-movie-card :movie="$movie" :viewMode="'grid'" :isBentoHero="false" x-bind:viewMode="layoutMode" />
                @endforeach
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('movies.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-velvet hover:bg-velvet-raised border border-marquee-gold/40 hover:border-marquee-gold text-champagne font-semibold text-sm transition shadow-lg">
                <span>Explore Complete 16-Film Catalog with Filters</span>
                <span>→</span>
            </a>
        </div>

    </section>

    <!-- 3. Nearby Cinemas in Active City Preview -->
    <section class="bg-velvet/50 border-t border-b border-velvet-border py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mb-10">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-open/15 text-emerald-open font-mono text-xs uppercase font-semibold">
                        Circuit Venues
                    </span>
                    <h2 class="font-display font-black text-2xl sm:text-3xl text-champagne mt-2">
                        Nearby Cinemas in {{ $activeCity->name ?? 'Jakarta' }}
                    </h2>
                    <p class="text-xs sm:text-sm text-silver-screen/80 mt-1">
                        Distances calculated via simulated geolocation & city coordinates.
                    </p>
                </div>

                <a href="{{ route('cinemas.index') }}" class="text-marquee-gold hover:text-champagne font-mono text-xs font-semibold flex items-center gap-1 transition">
                    <span>View All Circuit Venues</span>
                    <span>→</span>
                </a>
            </div>

            <!-- Cinema Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($cinemas->take(3) as $cinema)
                    <div class="rounded-2xl bg-velvet border border-velvet-border hover:border-marquee-gold/40 p-6 flex flex-col justify-between transition group shadow-md">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs font-mono">
                                <span class="px-2 py-0.5 rounded bg-obsidian text-marquee-gold font-bold border border-velvet-border">
                                    {{ $cinema->calculated_distance_km ?? 2.4 }} km away
                                </span>
                                <span class="inline-flex items-center gap-1 text-[11px] {{ $cinema->isBoxOfficeOpen() ? 'text-emerald-open' : 'text-amber-spotlight' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $cinema->isBoxOfficeOpen() ? 'bg-emerald-open' : 'bg-amber-spotlight' }}"></span>
                                    {{ $cinema->isBoxOfficeOpen() ? 'Box Office Open' : 'Opening Soon' }}
                                </span>
                            </div>

                            <h3 class="font-display font-bold text-lg text-champagne group-hover:text-marquee-gold transition">
                                <a href="{{ route('cinemas.show', $cinema) }}">{{ $cinema->name }}</a>
                            </h3>

                            <div class="text-xs text-silver-screen/70">
                                📍 {{ $cinema->neighborhood }} · {{ $cinema->address_line }}
                            </div>

                            <!-- Amenities & Auditoriums Tags -->
                            <div class="flex flex-wrap gap-1.5 pt-2">
                                @foreach($cinema->auditoriums as $aud)
                                    <span class="px-2 py-0.5 rounded bg-obsidian text-[10px] font-mono text-silver-screen border border-velvet-border">
                                        {{ $aud->screen_format }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-6 mt-6 border-t border-velvet-border flex items-center justify-between text-xs">
                            <span class="text-silver-screen/60 font-mono">{{ $cinema->auditoriums->count() }} Auditoriums</span>
                            <a href="{{ route('cinemas.show', $cinema) }}" class="text-marquee-gold hover:underline font-semibold flex items-center gap-1">
                                <span>Schedule</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-silver-screen">
                        No cinemas found for {{ $activeCity->name ?? 'Jakarta' }}. Switch city to view listings.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 4. Product Architecture & Milestone 1 Highlight -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="rounded-3xl bg-velvet border border-marquee-gold/30 p-8 sm:p-12 relative overflow-hidden">
            <div class="max-w-3xl space-y-4">
                <span class="px-3 py-1 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-bold tracking-wider">
                    Milestone 1 Architecture
                </span>
                <h2 class="font-display font-extrabold text-2xl sm:text-4xl text-champagne leading-tight">
                    Engineered for Production Browsing & Modular Phase 2 Slot-In
                </h2>
                <p class="text-xs sm:text-sm text-silver-screen/80 leading-relaxed">
                    Per the client specification, live seat booking and payments are excluded from Milestone 1. Instead, Matinee introduces the <code class="bg-obsidian px-1.5 py-0.5 rounded text-marquee-gold font-mono text-xs">TicketingSlotInterface</code> boundary, allowing Phase 2 interactive seat-map locking and payment gateways to slot in cleanly without refactoring core catalog or venue models.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 text-xs font-mono">
                    <div class="p-3.5 rounded-xl bg-obsidian border border-velvet-border">
                        <div class="text-marquee-gold font-bold text-sm">100% MySQL</div>
                        <div class="text-silver-screen/70 mt-1">Multi-city schema & indexed faceted search queries.</div>
                    </div>
                    <div class="p-3.5 rounded-xl bg-obsidian border border-velvet-border">
                        <div class="text-sky-upcoming font-bold text-sm">Full Animasi</div>
                        <div class="text-silver-screen/70 mt-1">3D poster tilt physics, foil glare & FLIP view morphing.</div>
                    </div>
                    <div class="p-3.5 rounded-xl bg-obsidian border border-velvet-border">
                        <div class="text-emerald-open font-bold text-sm">Phase 2 Ready</div>
                        <div class="text-silver-screen/70 mt-1">ShowtimeSlotContext DTO & verified preview drawer.</div>
                    </div>
                </div>

                <div class="pt-4 flex flex-wrap gap-4 text-xs">
                    <a href="{{ route('public.docs') }}" class="px-5 py-2.5 rounded-lg bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold transition">
                        Read Architecture Documentation
                    </a>
                    <a href="{{ route('demo.login') }}" class="px-5 py-2.5 rounded-lg bg-velvet-raised hover:bg-velvet border border-marquee-gold/40 text-champagne font-semibold transition">
                        Try Demo Roles (No Password)
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-dynamic-component>
