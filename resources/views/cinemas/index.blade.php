<x-dynamic-component :component="'layouts.public'" title="Circuit Cinemas & Auditoriums — Matinee">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Directory Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 pb-6 border-b border-velvet-border">
            <div>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-open/15 text-emerald-open font-mono text-xs uppercase font-bold tracking-wider">
                    Theatrical Venues
                </span>
                <h1 class="font-display font-black text-3xl sm:text-4xl text-champagne mt-2 tracking-wide">
                    Circuit Cinemas & Venues
                </h1>
                <p class="text-xs sm:text-sm text-silver-screen/80 mt-1">
                    Viewing cinemas in <strong>{{ $activeCity->name ?? 'Jakarta' }}</strong>. Distances calculated from active city center or simulated GPS.
                </p>
            </div>

            <div class="flex items-center gap-2">
                @if($showAllCities)
                    <a href="{{ route('cinemas.index') }}" class="px-3.5 py-1.5 rounded-lg bg-velvet border border-marquee-gold/40 text-marquee-gold text-xs font-mono font-medium transition">
                        Show {{ $activeCity->name ?? 'Jakarta' }} Only
                    </a>
                @else
                    <a href="{{ route('cinemas.index', ['all_cities' => 1]) }}" class="px-3.5 py-1.5 rounded-lg bg-velvet border border-velvet-border hover:border-marquee-gold/40 text-silver-screen hover:text-champagne text-xs font-mono transition">
                        Show All Cities ({{ $allCities->count() }})
                    </a>
                @endif
            </div>
        </div>

        <!-- Cinema List Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-10">
            @forelse($cinemas as $cinema)
                <div class="rounded-2xl bg-velvet border border-velvet-border hover:border-marquee-gold/40 p-6 sm:p-7 flex flex-col justify-between transition-all duration-300 shadow-xl group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-xs font-mono">
                            <span class="px-2 py-0.5 rounded bg-obsidian text-marquee-gold font-bold border border-velvet-border">
                                {{ $cinema->calculated_distance_km ?? 2.4 }} km
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-[11px] {{ $cinema->isBoxOfficeOpen() ? 'text-emerald-open' : 'text-amber-spotlight' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $cinema->isBoxOfficeOpen() ? 'bg-emerald-open' : 'bg-amber-spotlight' }}"></span>
                                {{ $cinema->isBoxOfficeOpen() ? 'Open Today' : 'Closed' }}
                            </span>
                        </div>

                        <div>
                            <span class="text-[10px] uppercase font-mono text-silver-screen/50 tracking-wider">
                                {{ $cinema->city->name }} Circuit
                            </span>
                            <h3 class="font-display font-bold text-xl text-champagne group-hover:text-marquee-gold transition mt-0.5">
                                <a href="{{ route('cinemas.show', $cinema) }}">{{ $cinema->name }}</a>
                            </h3>
                            <div class="text-xs text-silver-screen/70 mt-1 line-clamp-1">
                                {{ $cinema->neighborhood }} · {{ $cinema->address_line }}
                            </div>
                        </div>

                        @if($cinema->hero_badge)
                            <div class="px-2.5 py-1 rounded-lg bg-obsidian text-marquee-gold text-[11px] font-mono border border-marquee-gold/20 flex items-center gap-1.5">
                                <span>🏛️</span>
                                <span>{{ $cinema->hero_badge }}</span>
                            </div>
                        @endif

                        <!-- Amenities Tags -->
                        @if($cinema->amenities_json)
                            <div class="flex flex-wrap gap-1 pt-1">
                                @foreach(array_slice($cinema->amenities_json, 0, 3) as $amenity)
                                    <span class="px-2 py-0.5 rounded bg-obsidian text-[10px] font-mono text-silver-screen border border-velvet-border">
                                        {{ $amenity }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Footer Details -->
                    <div class="pt-6 mt-6 border-t border-velvet-border flex items-center justify-between text-xs">
                        <span class="text-silver-screen/70 font-mono">
                            {{ $cinema->auditoriums->count() }} Auditoriums
                        </span>
                        <a href="{{ route('cinemas.show', $cinema) }}" class="inline-flex items-center gap-1 text-marquee-gold hover:underline font-bold">
                            <span>Explore Screenings</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 text-silver-screen">
                    No cinemas found in this filter view.
                </div>
            @endforelse
        </div>

    </div>

</x-dynamic-component>
