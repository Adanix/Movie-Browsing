<x-dynamic-component :component="'layouts.manage'" title="Curation Overview — Matinee Backoffice">

    <div class="space-y-10">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-velvet-border">
            <div>
                <span class="px-2.5 py-0.5 rounded-full bg-sky-upcoming/15 text-sky-upcoming font-mono text-xs uppercase font-bold tracking-wider">
                    Executive Dashboard
                </span>
                <h1 class="font-display font-black text-2xl sm:text-3xl text-champagne mt-2 tracking-wide">
                    Curation & Venue Metrics
                </h1>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs text-silver-screen/70 font-mono">
                    Logged as: <strong class="text-champagne">{{ auth()->user()->name }}</strong>
                </span>
            </div>
        </div>

        <!-- KPI Metric Cards Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="p-4 rounded-2xl bg-velvet border border-velvet-border">
                <div class="text-[10px] uppercase font-mono text-silver-screen/60">Total Films</div>
                <div class="text-2xl font-bold font-mono text-champagne mt-1">{{ $metrics['total_movies'] }}</div>
                <div class="text-[10px] text-emerald-open font-mono mt-0.5">{{ $metrics['now_showing'] }} Now Showing</div>
            </div>

            <div class="p-4 rounded-2xl bg-velvet border border-velvet-border">
                <div class="text-[10px] uppercase font-mono text-silver-screen/60">Coming Soon</div>
                <div class="text-2xl font-bold font-mono text-sky-upcoming mt-1">{{ $metrics['coming_soon'] }}</div>
                <div class="text-[10px] text-silver-screen/60 font-mono mt-0.5">Rolling Advance</div>
            </div>

            <div class="p-4 rounded-2xl bg-velvet border border-velvet-border">
                <div class="text-[10px] uppercase font-mono text-silver-screen/60">Circuit Venues</div>
                <div class="text-2xl font-bold font-mono text-champagne mt-1">{{ $metrics['total_cinemas'] }}</div>
                <div class="text-[10px] text-marquee-gold font-mono mt-0.5">Across {{ $metrics['total_cities'] }} Cities</div>
            </div>

            <div class="p-4 rounded-2xl bg-velvet border border-velvet-border">
                <div class="text-[10px] uppercase font-mono text-silver-screen/60">Active Showtimes</div>
                <div class="text-2xl font-bold font-mono text-emerald-open mt-1">{{ $metrics['active_showtimes'] }}</div>
                <div class="text-[10px] text-silver-screen/60 font-mono mt-0.5">14-Day Calendar</div>
            </div>

            <div class="p-4 rounded-2xl bg-velvet border border-velvet-border">
                <div class="text-[10px] uppercase font-mono text-silver-screen/60">Watchlists</div>
                <div class="text-2xl font-bold font-mono text-marquee-gold mt-1">{{ $metrics['total_watchlists'] }}</div>
                <div class="text-[10px] text-silver-screen/60 font-mono mt-0.5">Saved Bookmarks</div>
            </div>

            <div class="p-4 rounded-2xl bg-velvet border border-velvet-border">
                <div class="text-[10px] uppercase font-mono text-silver-screen/60">Platform Status</div>
                <div class="text-base font-bold font-mono text-emerald-open mt-2">100% HEALTHY</div>
                <div class="text-[10px] text-silver-screen/60 font-mono mt-0.5">Zero Error Log</div>
            </div>
        </div>

        <!-- Studio Metadata Sync Simulator Panel (Admin Only) -->
        @if(auth()->user()->isAdmin())
        <div class="rounded-3xl bg-velvet border border-marquee-gold/30 p-6 sm:p-8 space-y-4 shadow-xl">
            <div class="flex items-center justify-between pb-3 border-b border-velvet-border">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-bold tracking-wider">
                        External Integration Simulator
                    </span>
                    <h2 class="font-display font-bold text-xl text-champagne mt-1">
                        Studio Metadata & Release Schedule Sync
                    </h2>
                </div>
            </div>

            <p class="text-xs text-silver-screen/80 max-w-2xl">
                Simulate syncing upstream studio film feeds (A24, Warner, Toho, Nusantara Noir) with configurable outcomes to test system resilience and audit logging.
            </p>

            <form action="{{ route('manage.sync.run') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-2 text-xs">
                @csrf
                <div class="sm:col-span-5">
                    <label class="block text-[10px] font-mono uppercase text-silver-screen/60 mb-1">Upstream Studio Feed</label>
                    <select name="source" class="w-full py-2.5 px-3 rounded-xl bg-obsidian border border-velvet-border text-champagne focus:border-marquee-gold focus:outline-none">
                        <option value="Studio Direct Feed (A24 / Neon Indie Archive)">A24 & Neon Indie Archive Feed</option>
                        <option value="Global Theatrical IMAX Consortium">Global Theatrical IMAX Consortium</option>
                        <option value="Asian Cinema Classics (Toho & Nusantara)">Asian Cinema Classics (Toho & Nusantara)</option>
                    </select>
                </div>

                <div class="sm:col-span-4">
                    <label class="block text-[10px] font-mono uppercase text-silver-screen/60 mb-1">Simulation Outcome</label>
                    <select name="outcome" class="w-full py-2.5 px-3 rounded-xl bg-obsidian border border-velvet-border text-champagne focus:border-marquee-gold focus:outline-none font-mono">
                        <option value="success">Outcome: Success (200 OK)</option>
                        <option value="partial">Outcome: Partial Sync (Warnings Logged)</option>
                        <option value="timeout">Outcome: Gateway Timeout (504 Error Handled)</option>
                    </select>
                </div>

                <div class="sm:col-span-3 flex items-end">
                    <button type="submit" class="w-full py-2.5 rounded-xl bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs uppercase tracking-wider transition shadow-lg cursor-pointer">
                        Execute Sync
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Recent Logs Grid: External Sync Logs & Demo Activity Logs -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- External Sync Logs Table -->
            <div class="rounded-2xl bg-velvet border border-velvet-border p-6 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-velvet-border">
                    <h3 class="font-display font-bold text-base text-champagne">External Sync Logs</h3>
                    <span class="text-xs font-mono text-silver-screen/60">MySQL Audit</span>
                </div>

                <div class="space-y-3">
                    @forelse($recentSyncs as $sync)
                        <div class="p-3.5 rounded-xl bg-obsidian border border-velvet-border text-xs space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-champagne font-semibold">{{ $sync->source }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold {{ $sync->status === 'success' ? 'bg-emerald-open/15 text-emerald-open' : ($sync->status === 'partial' ? 'bg-amber-spotlight/15 text-amber-spotlight' : 'bg-rose-alert/15 text-rose-alert') }}">
                                    {{ $sync->status }}
                                </span>
                            </div>
                            <p class="text-[11px] text-silver-screen/80 leading-relaxed">{{ $sync->summary }}</p>
                            <div class="text-[10px] font-mono text-silver-screen/50">{{ $sync->created_at->format('d M Y H:i:s') }}</div>
                        </div>
                    @empty
                        <p class="text-xs text-silver-screen/60">No sync logs recorded yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Demo Activity Logs Table -->
            <div class="rounded-2xl bg-velvet border border-velvet-border p-6 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-velvet-border">
                    <h3 class="font-display font-bold text-base text-champagne">Persona Activity Logs</h3>
                    <span class="text-xs font-mono text-silver-screen/60">Auth & Events</span>
                </div>

                <div class="space-y-3">
                    @forelse($recentLogs as $log)
                        <div class="p-3.5 rounded-xl bg-obsidian border border-velvet-border text-xs flex items-center justify-between gap-3">
                            <div>
                                <div class="font-mono text-champagne font-semibold flex items-center gap-1.5">
                                    <span class="text-marquee-gold">●</span>
                                    <span>{{ $log->persona_key ?: ($log->user->name ?? 'Guest') }}</span>
                                    <span class="text-silver-screen/50 text-[10px]">[{{ $log->event_type }}]</span>
                                </div>
                                <div class="text-[10px] font-mono text-silver-screen/50 mt-0.5">{{ $log->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="text-[10px] font-mono text-silver-screen/60 bg-velvet px-2 py-1 rounded">
                                {{ $log->ip_address }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-silver-screen/60">No activity logs recorded.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</x-dynamic-component>
