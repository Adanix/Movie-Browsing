<x-dynamic-component :component="'layouts.public'" :title="$movie->title . ' — Matinee Cinema Details'">

    <!-- Backdrop & Hero Banner Header -->
    <div class="relative bg-obsidian border-b border-velvet-border overflow-hidden pt-8 pb-16">
        <div class="absolute inset-0 bg-cover bg-center opacity-30" 
             style="background-image: url('{{ $movie->backdrop_image_url ?: $movie->poster_image_url }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-obsidian via-obsidian/85 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs font-mono text-silver-screen/60 mb-6">
                <a href="{{ route('public.home') }}" class="hover:text-champagne transition">Home</a>
                <span>/</span>
                <a href="{{ route('movies.index') }}" class="hover:text-champagne transition">Catalog</a>
                <span>/</span>
                <span class="text-marquee-gold">{{ $movie->title }}</span>
            </div>

            <!-- Top Grid: Poster + Film Information Header -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                
                <!-- Left: 3D Poster (Col 4) -->
                <div class="md:col-span-4 lg:col-span-3">
                    <div class="rounded-2xl overflow-hidden border border-marquee-gold/40 shadow-2xl bg-velvet aspect-[2/3] relative">
                        @if($movie->poster_image_url)
                            <img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col justify-between p-6 bg-velvet">
                                <span class="font-mono text-marquee-gold text-xs uppercase">Archival Print</span>
                                <span class="font-display font-bold text-xl text-champagne">{{ $movie->title }}</span>
                                <span class="text-xs font-mono text-silver-screen">★ {{ $movie->audience_score }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Action Buttons Below Poster -->
                    <div class="space-y-2 mt-4">
                        <button type="button" 
                                @click="$store.trailerModal.open('{{ $movie->slug }}')"
                                class="w-full py-3 rounded-xl bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 transition shadow-lg cursor-pointer">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <span>Watch Trailer</span>
                        </button>

                        <div class="grid grid-cols-2 gap-2">
                            <!-- Watchlist Toggle -->
                            <button type="button" 
                                    @click="$store.watchlist.toggle({{ $movie->id }})"
                                    class="py-2.5 px-3 rounded-xl bg-velvet hover:bg-velvet-raised border border-velvet-border hover:border-marquee-gold/40 text-silver-screen hover:text-marquee-gold font-medium text-xs flex items-center justify-center gap-1.5 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                <span>Watchlist</span>
                            </button>

                            <!-- Calendar Export -->
                            <a href="{{ route('movies.calendar', $movie) }}" 
                               class="py-2.5 px-3 rounded-xl bg-velvet hover:bg-velvet-raised border border-velvet-border hover:border-marquee-gold/40 text-silver-screen hover:text-champagne font-medium text-xs flex items-center justify-center gap-1.5 transition"
                               title="Download Premiere Reminder (.ics)">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>.ics File</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Information & Metadata (Col 8) -->
                <div class="md:col-span-8 lg:col-span-9 space-y-6">
                    
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded text-xs font-mono font-bold uppercase tracking-wider {{ $movie->release_status === 'now_showing' ? 'bg-emerald-open/20 text-emerald-open border border-emerald-open/40' : 'bg-sky-upcoming/20 text-sky-upcoming border border-sky-upcoming/40' }}">
                                {{ $movie->release_status === 'now_showing' ? 'Now Showing' : 'Coming Soon — Opens ' . $movie->release_date->format('l, d M Y') }}
                            </span>
                            <span class="px-2 py-0.5 rounded bg-obsidian text-marquee-gold text-xs font-mono font-bold border border-marquee-gold/30">
                                ★ {{ $movie->audience_score }}
                            </span>
                            <span class="px-2 py-0.5 rounded bg-obsidian text-silver-screen text-xs font-mono border border-velvet-border">
                                Critic: {{ $movie->critic_score }}%
                            </span>
                            <span class="px-2 py-0.5 rounded bg-obsidian text-silver-screen text-xs font-mono border border-velvet-border">
                                {{ $movie->age_rating }}
                            </span>
                        </div>

                        <h1 class="font-display font-black text-3xl sm:text-5xl text-champagne leading-tight">
                            {{ $movie->title }}
                        </h1>
                        @if($movie->original_title)
                            <div class="text-sm font-display text-silver-screen/70 italic mt-1">
                                {{ $movie->original_title }}
                            </div>
                        @endif
                    </div>

                    @if($movie->tagline)
                        <div class="text-base font-display text-marquee-gold italic font-medium">
                            "{{ $movie->tagline }}"
                        </div>
                    @endif

                    <!-- Technical Specs Pill Bar -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs font-mono">
                        <div class="p-3 rounded-xl bg-velvet border border-velvet-border">
                            <span class="text-silver-screen/50 block text-[10px] uppercase">Runtime</span>
                            <strong class="text-champagne">{{ $movie->formattedRuntime() }} ({{ $movie->runtime_minutes }} min)</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-velvet border border-velvet-border">
                            <span class="text-silver-screen/50 block text-[10px] uppercase">Audio / Spoken</span>
                            <strong class="text-marquee-gold uppercase">{{ $movie->audioLanguage->name ?? strtoupper($movie->audio_language_code) }}</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-velvet border border-velvet-border">
                            <span class="text-silver-screen/50 block text-[10px] uppercase">Subtitles</span>
                            <strong class="text-champagne uppercase">{{ implode(', ', $movie->subtitle_languages_json ?? ['EN']) }}</strong>
                        </div>
                        <div class="p-3 rounded-xl bg-velvet border border-velvet-border">
                            <span class="text-silver-screen/50 block text-[10px] uppercase">Projection & Sound</span>
                            <strong class="text-champagne">{{ $movie->sound_mix }}</strong>
                        </div>
                    </div>

                    <!-- Synopsis -->
                    <div class="space-y-2">
                        <h3 class="font-display font-bold text-sm text-champagne uppercase tracking-wider">Synopsis</h3>
                        <p class="text-sm text-silver-screen leading-relaxed">
                            {{ $movie->synopsis }}
                        </p>
                    </div>

                    <!-- Credits Grid -->
                    <div class="pt-4 border-t border-velvet-border grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-silver-screen/50 uppercase font-mono text-[10px]">Director & Production:</span>
                            <div class="text-champagne font-medium mt-0.5">{{ $movie->director_name ?: 'Aria Vance' }}</div>
                            <div class="text-silver-screen/70 text-[11px]">{{ $movie->studio_name }} · {{ $movie->country_of_origin }}</div>
                        </div>

                        <div>
                            <span class="text-silver-screen/50 uppercase font-mono text-[10px]">Featured Cast:</span>
                            <div class="text-champagne font-medium mt-0.5">
                                {{ $movie->credits->where('role_type', 'cast')->pluck('person_name')->join(', ') ?: 'Ensemble Cast' }}
                            </div>
                        </div>
                    </div>

                    <!-- Release Alert Subscribe Action (If Coming Soon) -->
                    @if($movie->release_status === 'coming_soon')
                        <div class="p-4 rounded-xl bg-sky-upcoming/10 border border-sky-upcoming/30 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
                            <div>
                                <strong class="text-champagne font-display block text-sm">Pre-Release Alert</strong>
                                <span class="text-silver-screen/80">Get notified when showtimes open for {{ $movie->title }} in {{ $activeCity->name ?? 'your city' }}.</span>
                            </div>
                            @auth
                                <form action="{{ route('watchlist.reminder', $movie) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-lg bg-sky-upcoming text-obsidian hover:bg-sky-400 font-bold font-mono uppercase text-xs transition cursor-pointer">
                                        {{ $isReminderSet ? 'Subscribed ✓' : 'Notify Me on Release' }}
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('demo.login') }}" class="px-4 py-2 rounded-lg bg-sky-upcoming text-obsidian hover:bg-sky-400 font-bold font-mono uppercase text-xs transition">
                                    Login to Subscribe
                                </a>
                            @endauth
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

    <!-- City-Scoped Showtime Schedule Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        
        <!-- Section Header with Inline City Switcher -->
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 pb-6 border-b border-velvet-border">
            <div>
                <span class="px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-bold tracking-wider">
                    Rolling 14-Day Calendar
                </span>
                <h2 class="font-display font-black text-2xl sm:text-3xl text-champagne mt-2">
                    Showtimes & Screenings
                </h2>
                <div class="flex items-center gap-2 text-xs text-silver-screen/70 mt-1">
                    <span>Showing at circuit venues in:</span>
                    <button type="button" @click="cityModal = true" class="text-marquee-gold font-bold underline hover:text-champagne font-mono">
                        {{ $activeCity->name ?? 'Jakarta' }} (Change City)
                    </button>
                </div>
            </div>
        </div>

        <!-- 14-Day Date Ribbon Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-6 border-b border-velvet-border">
            @foreach($dateTabs as $tab)
                <a href="{{ route('movies.show', ['movie' => $movie->slug, 'date' => $tab['date']]) }}" 
                   class="flex-shrink-0 px-4 py-2.5 rounded-xl border text-center transition min-w-[85px] {{ $tab['is_selected'] ? 'bg-marquee-gold text-obsidian font-bold border-marquee-gold shadow-lg' : 'bg-velvet border-velvet-border text-silver-screen hover:text-champagne hover:border-marquee-gold/40' }}">
                    <div class="text-[10px] uppercase font-mono tracking-wider opacity-80">{{ $tab['day_name'] }}</div>
                    <div class="text-sm font-mono font-bold mt-0.5">{{ $tab['day_num'] }}</div>
                </a>
            @endforeach
        </div>

        <!-- Cinema Listings & Showtimes Matrix -->
        <div class="mt-8 space-y-6">
            @forelse($cinemasWithShowtimes as $cinema)
                <div class="rounded-2xl bg-velvet border border-velvet-border hover:border-marquee-gold/30 p-6 space-y-4 transition">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 pb-3 border-b border-velvet-border">
                        <div>
                            <h3 class="font-display font-bold text-lg text-champagne">
                                <a href="{{ route('cinemas.show', $cinema) }}" class="hover:text-marquee-gold transition">{{ $cinema->name }}</a>
                            </h3>
                            <div class="text-xs text-silver-screen/70">
                                📍 {{ $cinema->neighborhood }} · {{ $cinema->address_line }}
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-[11px] font-mono">
                            <span class="px-2 py-0.5 rounded bg-obsidian text-marquee-gold border border-velvet-border">
                                {{ $cinema->city->currency_code }}
                            </span>
                        </div>
                    </div>

                    <!-- Showtime Pills Row -->
                    <div class="flex flex-wrap items-center gap-2.5 pt-1">
                        @foreach($cinema->date_showtimes as $st)
                            <button type="button" 
                                    @click="$store.showtimeDrawer.open({{ $st->id }})"
                                    class="group p-3 rounded-xl bg-obsidian hover:bg-marquee-gold border border-velvet-border hover:border-marquee-gold transition flex flex-col items-center min-w-[90px] cursor-pointer shadow-sm">
                                <span class="font-mono text-sm font-bold text-champagne group-hover:text-obsidian">
                                    {{ $st->formattedTime() }}
                                </span>
                                <span class="text-[9px] font-mono uppercase text-silver-screen/60 group-hover:text-obsidian/80 mt-0.5">
                                    {{ $st->presentation_format }}
                                </span>
                                @if($st->is_captioned_cc || $st->is_audio_described_ad)
                                    <div class="flex items-center gap-1 mt-1 text-[8px] font-mono text-marquee-gold group-hover:text-obsidian font-bold">
                                        @if($st->is_captioned_cc) <span>CC</span> @endif
                                        @if($st->is_audio_described_ad) <span>AD</span> @endif
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-velvet border border-velvet-border p-10 text-center space-y-3">
                    <div class="text-2xl">🏛️</div>
                    <h3 class="font-display font-bold text-base text-champagne">
                        No Screenings Scheduled in {{ $activeCity->name ?? 'Jakarta' }} on {{ Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
                    </h3>
                    <p class="text-xs text-silver-screen/70 max-w-md mx-auto">
                        There are no showtimes for this film on the selected date. Choose another date tab above or switch to a different city in the Matinee circuit.
                    </p>
                    <div class="pt-2">
                        <button type="button" @click="cityModal = true" class="px-4 py-2 rounded-lg bg-marquee-gold text-obsidian font-bold text-xs">
                            Switch Screening City
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

    </section>

</x-dynamic-component>
