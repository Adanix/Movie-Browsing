@props([
    'movie',
    'viewMode' => 'grid', // 'bento', 'grid', 'timeline'
    'isBentoHero' => false,
])

@php
    $palette = $movie->poster_palette_json ?? ['bg' => '#141118', 'accent' => '#F5C518', 'secondary' => '#E11D48'];
    $bgHex = $palette['bg'] ?? '#141118';
    $accentHex = $palette['accent'] ?? '#F5C518';
    $isNowShowing = ($movie->release_status === 'now_showing');
@endphp

@if($viewMode === 'timeline')
    <!-- Mode C: Lit Marquee Schedule & Filmstrip View -->
    <div class="rounded-xl bg-velvet border border-velvet-border hover:border-marquee-gold/40 p-4 transition flex flex-col md:flex-row items-start md:items-center justify-between gap-4 group">
        <!-- Thumbnail + Info -->
        <div class="flex items-center gap-4">
            <div class="w-16 h-24 rounded-lg bg-obsidian border border-velvet-border overflow-hidden flex-shrink-0 relative">
                @if($movie->poster_image_url)
                    <img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-xs font-display text-marquee-gold p-1 text-center" style="background: {{ $bgHex }};">
                        {{ substr($movie->title, 0, 10) }}
                    </div>
                @endif
            </div>

            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-semibold uppercase {{ $isNowShowing ? 'bg-emerald-open/15 text-emerald-open' : 'bg-sky-upcoming/15 text-sky-upcoming' }}">
                        {{ $isNowShowing ? 'Now Showing' : 'Opens ' . $movie->release_date->format('M d') }}
                    </span>
                    <span class="text-xs text-silver-screen/60 font-mono">{{ $movie->formattedRuntime() }}</span>
                    <span class="px-1.5 py-0.2 rounded bg-obsidian text-silver-screen text-[10px] font-mono border border-velvet-border">{{ $movie->age_rating }}</span>
                </div>
                <a href="{{ route('movies.show', $movie) }}" class="font-display font-bold text-base text-champagne group-hover:text-marquee-gold transition">
                    {{ $movie->title }}
                </a>
                <div class="text-xs text-silver-screen/70 mt-0.5 flex flex-wrap items-center gap-2">
                    <span>{{ $movie->genres->pluck('name')->join(' · ') }}</span>
                    <span>·</span>
                    <span class="text-marquee-gold uppercase font-mono text-[11px]">{{ strtoupper($movie->audio_language_code) }}</span>
                </div>
            </div>
        </div>

        <!-- Available Today Showtimes Pills -->
        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            @if($movie->showtimes && $movie->showtimes->isNotEmpty())
                <div class="text-[10px] text-silver-screen/50 uppercase font-mono w-full md:w-auto">Today:</div>
                @foreach($movie->showtimes->take(4) as $st)
                    <button type="button" 
                            @click="$store.showtimeDrawer.open({{ $st->id }})"
                            class="px-3 py-1.5 rounded bg-obsidian hover:bg-marquee-gold text-silver-screen hover:text-obsidian border border-velvet-border hover:border-marquee-gold font-mono text-xs font-medium transition cursor-pointer flex items-center gap-1">
                        <span>{{ $st->formattedTime() }}</span>
                        @if($st->presentation_format && str_contains($st->presentation_format, 'IMAX'))
                            <span class="text-[9px] text-marquee-gold group-hover:text-obsidian font-bold">IMAX</span>
                        @endif
                    </button>
                @endforeach
            @else
                <span class="text-xs text-silver-screen/50 italic">No scheduled screenings today in active city</span>
            @endif

            <div class="flex items-center gap-2 ml-auto md:ml-2">
                <button type="button" 
                        @click="$store.trailerModal.open('{{ $movie->slug }}')"
                        class="p-2 rounded bg-velvet-raised hover:bg-marquee-gold text-silver-screen hover:text-obsidian transition"
                        title="Watch Trailer">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </button>
                <a href="{{ route('movies.show', $movie) }}" 
                   class="px-3 py-1.5 rounded bg-velvet-raised hover:bg-velvet border border-marquee-gold/40 text-champagne text-xs font-medium transition">
                    Details →
                </a>
            </div>
        </div>
    </div>

@elseif($viewMode === 'bento' && $isBentoHero)
    <!-- Mode A Hero Bento Card (Spans 2x2 or 2 Cols) -->
    <div x-data="posterTilt" 
         @mousemove="handleMouseMove($event)" 
         @mouseleave="handleMouseLeave()"
         class="poster-3d-wrap md:col-span-2 relative group rounded-2xl overflow-hidden border border-velvet-border hover:border-marquee-gold/50 transition-all duration-300 shadow-xl bg-velvet"
         :style="`transform: perspective(1000px) rotateX(${rx}deg) rotateY(${ry}deg)`">
        
        <!-- Backdrop Ambient Glow -->
        <div class="absolute inset-0 bg-cover bg-center opacity-40 group-hover:opacity-55 group-hover:scale-105 transition-all duration-500"
             style="background-image: url('{{ $movie->backdrop_image_url ?: $movie->poster_image_url }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-obsidian via-obsidian/80 to-transparent"></div>
        <div class="poster-glare"></div>

        <!-- Content overlay -->
        <div class="relative p-6 sm:p-8 flex flex-col justify-end min-h-[380px] sm:min-h-[440px]">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-mono font-bold tracking-wider uppercase {{ $isNowShowing ? 'bg-emerald-open/20 text-emerald-open border border-emerald-open/40' : 'bg-sky-upcoming/20 text-sky-upcoming border border-sky-upcoming/40' }}">
                    {{ $isNowShowing ? '★ Spotlight Now Showing' : 'Opening ' . $movie->release_date->format('M d') }}
                </span>
                <span class="px-2 py-0.5 rounded bg-obsidian/80 text-marquee-gold text-xs font-mono font-bold border border-marquee-gold/30">
                    ★ {{ $movie->audience_score }}
                </span>
                <span class="text-xs text-silver-screen/80 font-mono">{{ $movie->formattedRuntime() }}</span>
                <span class="px-1.5 py-0.5 rounded bg-obsidian/80 text-silver-screen text-[10px] font-mono border border-velvet-border">{{ $movie->age_rating }}</span>
            </div>

            <h3 class="font-display font-black text-2xl sm:text-3xl text-champagne group-hover:text-marquee-gold transition leading-tight mb-2">
                <a href="{{ route('movies.show', $movie) }}">{{ $movie->title }}</a>
            </h3>

            <p class="text-xs sm:text-sm text-silver-screen/80 line-clamp-2 max-w-xl mb-4 leading-relaxed">
                {{ $movie->synopsis }}
            </p>

            <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-velvet-border/80">
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-marquee-gold font-mono uppercase font-semibold">{{ strtoupper($movie->audio_language_code) }} AUDIO</span>
                    <span class="text-silver-screen/40">·</span>
                    <span class="text-silver-screen">{{ $movie->genres->pluck('name')->take(2)->join(' / ') }}</span>
                </div>

                <div class="flex items-center gap-2.5">
                    <button type="button" 
                            @click="$store.trailerModal.open('{{ $movie->slug }}')"
                            class="px-4 py-2 rounded-lg bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs flex items-center gap-1.5 transition shadow-lg cursor-pointer">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <span>Trailer</span>
                    </button>
                    <a href="{{ route('movies.show', $movie) }}" 
                       class="px-4 py-2 rounded-lg bg-velvet-raised/90 hover:bg-velvet border border-marquee-gold/40 text-champagne text-xs font-semibold transition">
                        Showtimes & Details →
                    </a>
                </div>
            </div>
        </div>
    </div>

@else
    <!-- Standard Vertical Poster Card (Grid Mode & Bento Standard Card) -->
    <div x-data="posterTilt" 
         @mousemove="handleMouseMove($event)" 
         @mouseleave="handleMouseLeave()"
         class="poster-3d-wrap relative group rounded-2xl overflow-hidden border border-velvet-border hover:border-marquee-gold/50 transition-all duration-300 shadow-lg bg-velvet flex flex-col"
         :style="`transform: perspective(1000px) rotateX(${rx}deg) rotateY(${ry}deg)`">
        
        <!-- Poster Media Container (Aspect 2/3) -->
        <div class="aspect-[2/3] w-full relative overflow-hidden bg-obsidian">
            @if($movie->poster_image_url)
                <img src="{{ $movie->poster_image_url }}" 
                     alt="{{ $movie->title }}" 
                     loading="lazy"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
                <!-- Art-Deco SVG Geometric Poster Fallback -->
                <div class="w-full h-full flex flex-col justify-between p-5 relative" style="background: {{ $bgHex }};">
                    <div class="border border-marquee-gold/20 p-2 text-center">
                        <div class="text-[9px] font-mono tracking-widest text-marquee-gold uppercase">Matinee Archival</div>
                    </div>
                    <div class="text-center my-auto">
                        <div class="font-display font-bold text-lg text-champagne leading-tight mb-1">{{ $movie->title }}</div>
                        <div class="text-[10px] text-silver-screen/70 italic">{{ $movie->original_title }}</div>
                    </div>
                    <div class="text-center text-[10px] font-mono text-marquee-gold">
                        ★ {{ $movie->audience_score }} · {{ $movie->age_rating }}
                    </div>
                </div>
            @endif

            <!-- Top Floating Badges -->
            <div class="absolute top-3 inset-x-3 flex items-center justify-between gap-1 z-10 pointer-events-none">
                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold tracking-wider uppercase shadow-md {{ $isNowShowing ? 'bg-obsidian/90 text-emerald-open border border-emerald-open/40' : 'bg-obsidian/90 text-sky-upcoming border border-sky-upcoming/40' }}">
                    {{ $isNowShowing ? 'Now Showing' : $movie->release_date->format('M d') }}
                </span>
                
                <span class="px-1.5 py-0.5 rounded bg-obsidian/90 text-marquee-gold text-[11px] font-mono font-bold border border-marquee-gold/40 flex items-center gap-0.5 shadow-md">
                    ★ {{ $movie->audience_score }}
                </span>
            </div>

            <!-- Gradient bottom fade -->
            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-velvet via-velvet/80 to-transparent pointer-events-none"></div>

            <!-- Specular Glare Layer -->
            <div class="poster-glare"></div>

            <!-- Hover Curtain Action Drawer -->
            <div class="absolute inset-0 bg-obsidian/85 backdrop-blur-sm p-4 flex flex-col justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-20">
                <div class="space-y-2">
                    <div class="text-[10px] font-mono uppercase text-marquee-gold tracking-widest font-bold">Quick Overview</div>
                    <p class="text-xs text-silver-screen leading-relaxed line-clamp-4">
                        {{ $movie->synopsis }}
                    </p>
                    <div class="pt-2 text-[11px] space-y-1">
                        <div class="text-champagne font-medium">Director: {{ $movie->director_name ?: 'Matinee Curator' }}</div>
                        <div class="text-silver-screen/70">Audio: {{ strtoupper($movie->audio_language_code) }} · Sub: {{ implode('/', $movie->subtitle_languages_json ?? ['EN']) }}</div>
                    </div>
                </div>

                <!-- Hover Actions -->
                <div class="space-y-2 pt-3 border-t border-velvet-border">
                    <button type="button" 
                            @click="$store.trailerModal.open('{{ $movie->slug }}')"
                            class="w-full py-2 rounded bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs flex items-center justify-center gap-1.5 transition cursor-pointer">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        <span>Watch Trailer</span>
                    </button>

                    <a href="{{ route('movies.show', $movie) }}" 
                       class="w-full py-2 rounded bg-velvet-raised hover:bg-velvet border border-marquee-gold/40 text-champagne text-xs font-semibold flex items-center justify-center transition">
                        Full Showtimes
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Footer Info -->
        <div class="p-4 flex-1 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-1.5 text-[10px] font-mono text-silver-screen/60 uppercase mb-1">
                    <span>{{ $movie->genres->first()?->name ?? 'Cinema' }}</span>
                    <span>·</span>
                    <span>{{ $movie->formattedRuntime() }}</span>
                </div>
                <h4 class="font-display font-bold text-sm text-champagne group-hover:text-marquee-gold transition leading-snug line-clamp-1">
                    <a href="{{ route('movies.show', $movie) }}">{{ $movie->title }}</a>
                </h4>
            </div>

            <!-- Next Available Showtimes Strip (Today) -->
            <div class="mt-3 pt-2.5 border-t border-velvet-border/60 flex items-center justify-between text-[11px]">
                @if($movie->showtimes && $movie->showtimes->isNotEmpty())
                    <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar">
                        @foreach($movie->showtimes->take(3) as $st)
                            <button type="button" 
                                    @click="$store.showtimeDrawer.open({{ $st->id }})"
                                    class="px-2 py-0.5 rounded bg-obsidian hover:bg-marquee-gold text-silver-screen hover:text-obsidian border border-velvet-border font-mono text-[10px] transition cursor-pointer"
                                    title="{{ $st->cinema->name ?? '' }}">
                                {{ $st->formattedTime() }}
                            </button>
                        @endforeach
                    </div>
                @else
                    <span class="text-[10px] text-silver-screen/40 italic">Check city showtimes</span>
                @endif

                <button type="button" 
                        @click="$store.watchlist.toggle({{ $movie->id }})"
                        class="text-silver-screen hover:text-marquee-gold transition p-1"
                        title="Save to Watchlist">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                </button>
            </div>
        </div>

    </div>
@endif
