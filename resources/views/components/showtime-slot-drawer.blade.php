<x-dynamic-component :component="'layouts.public'" :title="'Screening Preview: ' . $slot->movieTitle . ' at ' . $slot->cinemaName . ' — Matinee'">
<div class="py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">

    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ url()->previous(route('public.home')) }}" class="inline-flex items-center gap-1.5 text-xs text-silver-screen hover:text-champagne transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Return to Catalog</span>
        </a>
        <span class="px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold text-xs font-mono font-medium">
            Milestone 1 Preview Boundary
        </span>
    </div>

    <!-- Main Card -->
    <div class="rounded-2xl bg-velvet border border-marquee-gold/30 p-6 sm:p-8 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-60 h-60 bg-marquee-gold/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="space-y-6">
            <!-- Header -->
            <div>
                <div class="text-[11px] font-mono uppercase tracking-wider text-marquee-gold mb-1">
                    Theatrical Slot Context
                </div>
                <h1 class="font-display font-extrabold text-2xl sm:text-3xl text-champagne">
                    {{ $slot->movieTitle }}
                </h1>
                <p class="text-xs text-silver-screen/80 mt-1">
                    {{ $slot->cinemaName }} · {{ $slot->auditoriumName }} ({{ $slot->cityName }})
                </p>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 p-4 rounded-xl bg-obsidian border border-velvet-border text-xs">
                <div>
                    <div class="text-silver-screen/50 text-[10px] uppercase font-mono">Date</div>
                    <div class="text-champagne font-bold mt-0.5">{{ \Carbon\Carbon::parse($slot->startsAt)->format('D, d M Y') }}</div>
                </div>

                <div>
                    <div class="text-silver-screen/50 text-[10px] uppercase font-mono">Showtime Window</div>
                    <div class="text-marquee-gold font-mono font-bold mt-0.5">
                        {{ \Carbon\Carbon::parse($slot->startsAt)->format('H:i') }} – {{ \Carbon\Carbon::parse($slot->endsAt)->format('H:i') }}
                    </div>
                </div>

                <div>
                    <div class="text-silver-screen/50 text-[10px] uppercase font-mono">Projection / Sound</div>
                    <div class="text-champagne font-bold mt-0.5">{{ $slot->screenFormat }}</div>
                </div>

                <div>
                    <div class="text-silver-screen/50 text-[10px] uppercase font-mono">Base Admission</div>
                    <div class="text-champagne font-mono font-bold mt-0.5">{{ $slot->formattedPrice }}</div>
                </div>

                <div>
                    <div class="text-silver-screen/50 text-[10px] uppercase font-mono">Capacity Estimate</div>
                    <div class="text-emerald-open font-mono font-bold mt-0.5">{{ $slot->availableSeatsCount }} Seats</div>
                </div>

                <div>
                    <div class="text-silver-screen/50 text-[10px] uppercase font-mono">Accessibility</div>
                    <div class="flex items-center gap-1 mt-0.5 font-mono text-[10px] text-silver-screen">
                        @forelse($slot->accessibilityBadges as $tag)
                            <span class="px-1.5 py-0.5 rounded bg-velvet text-marquee-gold border border-velvet-border">
                                {{ is_array($tag) ? ($tag['code'] ?? $tag['name'] ?? 'ACC') : $tag }}
                            </span>
                        @empty
                            <span>Standard</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Phase 2 Architecture Notice -->
            <div class="p-4 rounded-xl bg-velvet-raised border border-velvet-border text-xs space-y-2">
                <div class="flex items-center gap-2 text-marquee-gold font-bold font-mono">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Phase 2 Slot-In Ready Architecture</span>
                </div>
                <p class="text-silver-screen/80 leading-relaxed text-[11px]">
                    Under Milestone 1 scope, seat reservation and payment gateways are decoupled behind the modular <code class="bg-obsidian px-1.5 py-0.5 rounded text-marquee-gold font-mono">TicketingSlotInterface</code>. This verified context contract will hand over directly to Phase 2 ticketing engines.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <a href="{{ route('movies.calendar', ['movie' => $slot->movieSlug, 'showtime_id' => $slot->showtimeId]) }}" 
                   class="flex-1 py-3 px-4 rounded-xl bg-velvet-raised hover:bg-velvet border border-marquee-gold/40 text-champagne hover:text-marquee-gold font-medium text-xs flex items-center justify-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Download Calendar (.ics)</span>
                </a>

                <button type="button" 
                        @click="$store.watchlist.toggle({{ $showtime->movie_id }})" 
                        class="flex-1 py-3 px-4 rounded-xl bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs flex items-center justify-center gap-2 transition shadow-lg shadow-marquee-gold/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    <span>Add Movie to Watchlist</span>
                </button>
            </div>

        </div>
    </div>

</div>
</x-dynamic-component>
