<x-dynamic-component :component="'layouts.public'" title="My Watchlist & Release Alerts — Matinee">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 pb-6 border-b border-velvet-border">
            <div>
                <span class="px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-bold tracking-wider">
                    Member Personalization
                </span>
                <h1 class="font-display font-black text-3xl sm:text-4xl text-champagne mt-2 tracking-wide">
                    My Watchlist & Release Alerts
                </h1>
                <p class="text-xs sm:text-sm text-silver-screen/80 mt-1">
                    Bookmarked films and upcoming release night alerts.
                </p>
            </div>

            @guest
                <div class="p-3 rounded-xl bg-velvet border border-marquee-gold/30 flex items-center gap-3 text-xs">
                    <span>Viewing as Guest (Session Only).</span>
                    <a href="{{ route('demo.login') }}" class="px-3 py-1.5 rounded bg-marquee-gold text-obsidian font-bold hover:bg-amber-spotlight transition">
                        Log in as Elena Vance →
                    </a>
                </div>
            @endguest
        </div>

        <!-- Section 1: Bookmarked Movies Grid -->
        <section class="space-y-6">
            <div class="flex items-center justify-between pb-2 border-b border-velvet-border/50">
                <h2 class="font-display font-bold text-xl text-champagne flex items-center gap-2">
                    <span>Saved Films</span>
                    <span class="text-xs font-mono px-2 py-0.5 rounded-full bg-marquee-gold/20 text-marquee-gold">
                        {{ $watchlistItems->count() }}
                    </span>
                </h2>
            </div>

            @if($watchlistItems->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($watchlistItems as $item)
                        @php $movie = $item->movie; @endphp
                        <div class="rounded-2xl bg-velvet border border-velvet-border hover:border-marquee-gold/40 p-4 flex flex-col justify-between transition group shadow-md relative">
                            <div class="space-y-3">
                                <div class="aspect-[2/3] w-full rounded-xl overflow-hidden bg-obsidian relative">
                                    @if($movie->poster_image_url)
                                        <img src="{{ $movie->poster_image_url }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center font-display text-sm text-marquee-gold p-2 text-center bg-velvet">
                                            {{ $movie->title }}
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <div class="text-[10px] font-mono text-silver-screen/60 uppercase">
                                        {{ $movie->genres->pluck('name')->take(2)->join(' · ') }}
                                    </div>
                                    <h3 class="font-display font-bold text-base text-champagne group-hover:text-marquee-gold transition mt-0.5">
                                        <a href="{{ route('movies.show', $movie) }}">{{ $movie->title }}</a>
                                    </h3>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-velvet-border flex items-center justify-between text-xs">
                                <form action="{{ route('watchlist.toggle') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                    <button type="submit" class="text-rose-alert hover:underline text-[11px] font-mono cursor-pointer">
                                        Remove ×
                                    </button>
                                </form>

                                <a href="{{ route('movies.show', $movie) }}" class="text-marquee-gold hover:underline font-bold text-xs">
                                    Showtimes →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl bg-velvet border border-velvet-border p-10 text-center space-y-3">
                    <div class="text-2xl">🔖</div>
                    <div class="font-display font-bold text-base text-champagne">Your Watchlist is Empty</div>
                    <p class="text-xs text-silver-screen/70">Explore the catalog and click the bookmark icon on any film to save it.</p>
                    <a href="{{ route('movies.index') }}" class="inline-block mt-2 px-4 py-2 rounded-lg bg-marquee-gold text-obsidian font-bold text-xs">
                        Browse Catalog
                    </a>
                </div>
            @endif
        </section>

        <!-- Section 2: Release Reminders Subscriptions -->
        @auth
        <section class="space-y-6 pt-6 border-t border-velvet-border">
            <h2 class="font-display font-bold text-xl text-champagne flex items-center gap-2">
                <span>Opening Night Alerts</span>
                <span class="text-xs font-mono px-2 py-0.5 rounded-full bg-sky-upcoming/20 text-sky-upcoming">
                    {{ $releaseReminders->count() }}
                </span>
            </h2>

            @if($releaseReminders->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($releaseReminders as $reminder)
                        <div class="rounded-xl bg-velvet border border-velvet-border p-4 flex items-center justify-between gap-4">
                            <div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-sky-upcoming/15 text-sky-upcoming uppercase font-bold">
                                    Opens {{ $reminder->movie->release_date->format('l, d M Y') }}
                                </span>
                                <h3 class="font-display font-bold text-base text-champagne mt-1">
                                    <a href="{{ route('movies.show', $reminder->movie) }}">{{ $reminder->movie->title }}</a>
                                </h3>
                                <div class="text-xs text-silver-screen/70">
                                    Alert City: {{ $reminder->city->name }}
                                </div>
                            </div>

                            <form action="{{ route('watchlist.reminder', $reminder->movie) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 rounded bg-obsidian text-silver-screen hover:text-rose-alert text-xs font-mono border border-velvet-border" title="Unsubscribe Alert">
                                    Unsubscribe
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-silver-screen/60">No active opening-night alerts subscribed.</p>
            @endif
        </section>

        <!-- Section 3: Simulated Email Notification Log -->
        <section class="space-y-4 pt-6 border-t border-velvet-border">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-display font-bold text-base text-champagne">Simulated Notification Log (Email)</h3>
                    <p class="text-xs text-silver-screen/70">Audit of simulated release alerts dispatched to your email address.</p>
                </div>
            </div>

            <div class="space-y-2">
                @forelse($notificationLogs as $log)
                    <div class="p-3.5 rounded-xl bg-obsidian border border-velvet-border text-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                        <div class="space-y-1">
                            <div class="font-mono text-marquee-gold font-bold">{{ $log->subject }}</div>
                            <div class="text-silver-screen/80 text-[11px] font-mono">To: {{ $log->recipient_email }} · Sent: {{ $log->sent_at->format('d M Y H:i:s') }}</div>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-emerald-open/15 text-emerald-open text-[10px] font-mono uppercase font-bold">
                            Delivered
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-silver-screen/60">No notification logs recorded yet.</p>
                @endforelse
            </div>
        </section>
        @endauth

    </div>

</x-dynamic-component>
