<x-dynamic-component :component="'layouts.public'" :title="$cinema->name . ' — Matinee Cinema Venue'">

    <!-- Venue Header Banner -->
    <div class="relative bg-obsidian border-b border-velvet-border pt-8 pb-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-2 text-xs font-mono text-silver-screen/60 mb-6">
                <a href="{{ route('public.home') }}" class="hover:text-champagne transition">Home</a>
                <span>/</span>
                <a href="{{ route('cinemas.index') }}" class="hover:text-champagne transition">Cinemas</a>
                <span>/</span>
                <span class="text-marquee-gold">{{ $cinema->name }}</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
                <div class="md:col-span-8 space-y-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs font-bold uppercase tracking-wider">
                            {{ $cinema->city->name }} Circuit
                        </span>
                        <span class="px-2.5 py-0.5 rounded bg-obsidian text-emerald-open border border-emerald-open/30 text-xs font-mono">
                            {{ $cinema->isBoxOfficeOpen() ? 'Box Office Open Today' : 'Closed' }}
                        </span>
                    </div>

                    <h1 class="font-display font-black text-3xl sm:text-5xl text-champagne leading-tight">
                        {{ $cinema->name }}
                    </h1>

                    <div class="text-xs sm:text-sm text-silver-screen flex items-center gap-2">
                        <span>📍 {{ $cinema->address_line }}, {{ $cinema->neighborhood }}</span>
                    </div>

                    @if($cinema->architectural_style)
                        <div class="text-xs font-display text-marquee-gold italic">
                            Architecture: {{ $cinema->architectural_style }}
                        </div>
                    @endif

                    <!-- Amenities list -->
                    @if($cinema->amenities_json)
                        <div class="flex flex-wrap gap-2 pt-2">
                            @foreach($cinema->amenities_json as $am)
                                <span class="px-2.5 py-1 rounded bg-velvet text-xs font-mono text-champagne border border-velvet-border">
                                    ✓ {{ $am }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Box: Auditoriums & Transit -->
                <div class="md:col-span-4 rounded-2xl bg-velvet border border-velvet-border p-5 space-y-4 text-xs">
                    <div>
                        <div class="font-mono text-marquee-gold uppercase font-bold text-[10px] mb-2">Auditorium Directory ({{ $cinema->auditoriums->count() }})</div>
                        <div class="space-y-1.5">
                            @foreach($cinema->auditoriums as $aud)
                                <div class="p-2 rounded bg-obsidian border border-velvet-border flex items-center justify-between">
                                    <span class="text-champagne font-medium">{{ $aud->name }}</span>
                                    <span class="font-mono text-[10px] text-marquee-gold">{{ $aud->total_capacity }} seats</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-3 border-t border-velvet-border">
                        <div class="font-mono text-silver-screen/50 uppercase text-[10px] mb-1">Transit & Parking Note</div>
                        <p class="text-silver-screen/80 leading-relaxed text-[11px]">
                            {{ $cinema->transit_and_parking_note ?: 'Basement parking and drop-off canopy available.' }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- 14-Day Cinema Schedule Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 pb-6 border-b border-velvet-border">
            <div>
                <span class="px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-bold tracking-wider">
                    Program Schedule
                </span>
                <h2 class="font-display font-black text-2xl sm:text-3xl text-champagne mt-2">
                    Films Playing at {{ $cinema->name }}
                </h2>
            </div>
        </div>

        <!-- 14-Day Date Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-6 border-b border-velvet-border">
            @foreach($dateTabs as $tab)
                <a href="{{ route('cinemas.show', ['cinema' => $cinema->slug, 'date' => $tab['date']]) }}" 
                   class="flex-shrink-0 px-4 py-2.5 rounded-xl border text-center transition min-w-[85px] {{ $tab['is_selected'] ? 'bg-marquee-gold text-obsidian font-bold border-marquee-gold shadow-lg' : 'bg-velvet border-velvet-border text-silver-screen hover:text-champagne hover:border-marquee-gold/40' }}">
                    <div class="text-[10px] uppercase font-mono tracking-wider opacity-80">{{ $tab['day_name'] }}</div>
                    <div class="text-sm font-mono font-bold mt-0.5">{{ $tab['day_num'] }}</div>
                </a>
            @endforeach
        </div>

        <!-- Film Schedule Grid -->
        <div class="mt-8 space-y-6">
            @forelse($moviesPlaying as $movie)
                <div class="rounded-2xl bg-velvet border border-velvet-border hover:border-marquee-gold/30 p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 transition">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-24 rounded-lg bg-obsidian border border-velvet-border overflow-hidden flex-shrink-0">
                            @if($movie->poster_image_url)
                                <img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-[10px] text-marquee-gold font-mono p-1 text-center">
                                    {{ substr($movie->title, 0, 10) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-marquee-gold/15 text-marquee-gold">
                                    {{ $movie->formattedRuntime() }}
                                </span>
                                <span class="text-xs text-silver-screen font-mono">{{ $movie->age_rating }}</span>
                            </div>
                            <h3 class="font-display font-bold text-lg text-champagne hover:text-marquee-gold transition">
                                <a href="{{ route('movies.show', $movie) }}">{{ $movie->title }}</a>
                            </h3>
                            <div class="text-xs text-silver-screen/70 mt-0.5">
                                {{ $movie->genres->pluck('name')->join(' · ') }}
                            </div>
                        </div>
                    </div>

                    <!-- Showtime Pills -->
                    <div class="flex flex-wrap items-center gap-2">
                        @foreach($movie->day_showtimes as $st)
                            <button type="button" 
                                    @click="$store.showtimeDrawer.open({{ $st->id }})"
                                    class="px-3 py-2 rounded-xl bg-obsidian hover:bg-marquee-gold text-silver-screen hover:text-obsidian border border-velvet-border hover:border-marquee-gold font-mono text-xs font-bold transition flex flex-col items-center cursor-pointer">
                                <span>{{ $st->formattedTime() }}</span>
                                <span class="text-[9px] font-normal uppercase opacity-75">{{ $st->presentation_format }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-velvet border border-velvet-border p-12 text-center space-y-3">
                    <div class="text-2xl">📽️</div>
                    <h3 class="font-display font-bold text-base text-champagne">
                        No Screenings at this Cinema on {{ Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
                    </h3>
                    <p class="text-xs text-silver-screen/70 max-w-sm mx-auto">
                        Please choose a different date tab above to view scheduled screenings.
                    </p>
                </div>
            @endforelse
        </div>

    </section>

</x-dynamic-component>
