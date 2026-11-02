<x-dynamic-component :component="'layouts.public'" title="Product & Architecture Documentation — Matinee">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Docs Header -->
        <div class="border-b border-velvet-border pb-8 mb-10">
            <span class="px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-semibold">
                Product Guide & Technical Specification
            </span>
            <h1 class="font-display font-black text-3xl sm:text-5xl text-champagne mt-2 tracking-wide">
                Matinee Platform Documentation
            </h1>
            <p class="text-xs sm:text-sm text-silver-screen/80 mt-2 max-w-2xl leading-relaxed">
                Complete guide to Milestone 1 browsing, animated movie catalog, multi-city cinema discovery, persona workflows, and Phase 2 modular slot-in boundaries.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Sticky Sidebar Table of Contents (Desktop) -->
            <aside class="hidden lg:block lg:col-span-3">
                <div class="sticky top-24 rounded-2xl bg-velvet border border-velvet-border p-5 space-y-3 text-xs">
                    <div class="font-mono text-marquee-gold font-bold uppercase tracking-wider text-[11px] pb-2 border-b border-velvet-border">
                        Table of Contents
                    </div>
                    <nav class="space-y-1.5">
                        <a href="#overview" class="block text-silver-screen hover:text-champagne transition py-1">1. Product Overview</a>
                        <a href="#personas" class="block text-silver-screen hover:text-champagne transition py-1">2. Persona Quick Login</a>
                        <a href="#catalog" class="block text-silver-screen hover:text-champagne transition py-1">3. Animated Catalog & 3D Tilt</a>
                        <a href="#filters" class="block text-silver-screen hover:text-champagne transition py-1">4. Multi-Criteria Filtering</a>
                        <a href="#venues" class="block text-silver-screen hover:text-champagne transition py-1">5. Multi-City & Nearby Venues</a>
                        <a href="#phase2" class="block text-marquee-gold hover:text-champagne font-semibold transition py-1">6. Phase 2 Slot-In Architecture</a>
                        <a href="#simulations" class="block text-silver-screen hover:text-champagne transition py-1">7. Simulated Dependencies</a>
                        <a href="#customization" class="block text-silver-screen hover:text-champagne transition py-1">8. Customization Notice</a>
                    </nav>
                </div>
            </aside>

            <!-- Main Documentation Content -->
            <div class="lg:col-span-9 space-y-14 text-sm leading-relaxed text-silver-screen">
                
                <!-- 1. Overview -->
                <section id="overview" class="space-y-4">
                    <h2 class="font-display font-bold text-2xl text-champagne">1. Product Overview & Milestone 1 Scope</h2>
                    <p>
                        <strong>Matinee</strong> is a multi-city cinema discovery, catalog browsing, and showtime scheduling platform built with an atmospheric Art-Deco aesthetic ("Velvet Noir & Warm Marquee Gold") inspired by the Freeframe Matinee design system.
                    </p>
                    <p>
                        This release delivers <strong>Milestone 1</strong>, focusing on production-grade browsing: complete movie metadata, release dates, trailers, multi-criteria faceted search (Genre, Language, Release Date, Screening Date), multi-city venue exploration, member watchlists, and curator backoffice management.
                    </p>
                </section>

                <!-- 2. Personas -->
                <section id="personas" class="space-y-4 pt-6 border-t border-velvet-border">
                    <h2 class="font-display font-bold text-2xl text-champagne">2. Getting Started & Demo Personas</h2>
                    <p>
                        To ensure seamless evaluation without filling in registration forms or resetting passwords, Matinee provides a dedicated passwordless quick-login portal at <a href="{{ route('demo.login') }}" class="text-marquee-gold hover:underline font-mono">/demo/login</a>.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                        <div class="p-4 rounded-xl bg-velvet border border-velvet-border space-y-2">
                            <div class="text-marquee-gold font-bold text-xs uppercase font-mono">Elena Vance</div>
                            <div class="text-champagne font-semibold text-sm">Cinema Member</div>
                            <p class="text-xs text-silver-screen/80 leading-relaxed">Persistent MySQL Watchlist, preferred city preferences, and opening-night alert subscriptions.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-velvet border border-velvet-border space-y-2">
                            <div class="text-emerald-open font-bold text-xs uppercase font-mono">Marcus Sterling</div>
                            <div class="text-champagne font-semibold text-sm">Regional Manager</div>
                            <p class="text-xs text-silver-screen/80 leading-relaxed">Manages assigned Jakarta & Bandung venues, auditoriums, and schedules daily screenings with conflict validation.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-velvet border border-velvet-border space-y-2">
                            <div class="text-sky-upcoming font-bold text-xs uppercase font-mono">Aria Chen</div>
                            <div class="text-champagne font-semibold text-sm">Platform Curator</div>
                            <p class="text-xs text-silver-screen/80 leading-relaxed">Full Movie Catalog CRUD, release dates, trailer management, and external Studio Feed Sync simulation.</p>
                        </div>
                    </div>
                </section>

                <!-- 3. Animated Catalog -->
                <section id="catalog" class="space-y-4 pt-6 border-t border-velvet-border">
                    <h2 class="font-display font-bold text-2xl text-champagne">3. Non-Rigid, Fully Animated Movie Catalog</h2>
                    <p>
                        Per the design directive <em>"Bagian katalog movie buat yg menarik ga kaku full animasi"</em>, Matinee introduces three distinct, kinetic layout modes accessible on <a href="{{ route('movies.index') }}" class="text-marquee-gold hover:underline font-mono">/movies</a>:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-2 text-xs sm:text-sm">
                        <li><strong>Mode A — Editorial Bento Showcase (Default):</strong> An asymmetric magazine-style CSS Grid where featured releases occupy 2x2 hero cells with synopsis excerpts, while standard cards nest gracefully alongside.</li>
                        <li><strong>Mode B — Interactive 3D Poster Grid:</strong> Staggered masonry cards with cursor-tracked 3D card tilt and specular foil reflection overlay.</li>
                        <li><strong>Mode C — Marquee Schedule Timeline:</strong> A theatrical horizontal filmstrip showing rolling daily screening times per cinema alongside animated poster thumbnails.</li>
                    </ul>
                </section>

                <!-- 4. Filters -->
                <section id="filters" class="space-y-4 pt-6 border-t border-velvet-border">
                    <h2 class="font-display font-bold text-2xl text-champagne">4. Multi-Criteria Search & Faceted Filtering</h2>
                    <p>
                        The catalog query engine (<code class="bg-velvet px-1.5 py-0.5 rounded text-marquee-gold font-mono text-xs">MovieCatalogQueryService</code>) executes indexed, zero-N+1 Eloquent queries supporting compound filters:
                    </p>
                    <div class="p-4 rounded-xl bg-velvet border border-velvet-border space-y-2 text-xs font-mono">
                        <div><strong class="text-champagne">Keyword Search (q):</strong> Matches movie title, original title, director, synopsis, and cast credits.</div>
                        <div><strong class="text-champagne">Genre:</strong> Filters by single or multiple genre slugs (Sci-Fi, Noir, Drama, Animation, etc.).</div>
                        <div><strong class="text-champagne">Spoken Language:</strong> Filters by primary audio language code (ja, en, id, ko, fr, zh, es).</div>
                        <div><strong class="text-champagne">Subtitle Language:</strong> Filters by subtitle availability JSON array.</div>
                        <div><strong class="text-champagne">Release Date:</strong> Presets (This Week, This Month, Next Month) or custom Date From / Date To range.</div>
                        <div><strong class="text-champagne">City Availability:</strong> Automatically scopes active city screenings.</div>
                    </div>
                </section>

                <!-- 5. Venues -->
                <section id="venues" class="space-y-4 pt-6 border-t border-velvet-border">
                    <h2 class="font-display font-bold text-2xl text-champagne">5. Multi-City & Nearby Cinema Discovery</h2>
                    <p>
                        Visitors can switch between 5 supported cities: <strong>Jakarta, Bandung, Surabaya, Bali (Denpasar)</strong>, and <strong>Missoula MT (The 1931 Garnet Flagship)</strong>.
                    </p>
                    <p>
                        Distances to nearby circuit venues are computed deterministically via the Haversine formula in <code class="bg-velvet px-1.5 py-0.5 rounded text-marquee-gold font-mono text-xs">SimulatedGeolocationService</code>. Visitors can also test the "Simulate Geolocation" feature in the City Selector modal.
                    </p>
                </section>

                <!-- 6. Phase 2 Slot-In Boundary -->
                <section id="phase2" class="space-y-4 pt-6 border-t border-velvet-border">
                    <h2 class="font-display font-bold text-2xl text-champagne flex items-center gap-2">
                        <span>6. Phase 2 Slot-In Architecture</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-bold">Verified Boundary</span>
                    </h2>
                    <p>
                        In strict compliance with the client mandate (<em>"Nothing beyond browsing has to function yet—seat selection and payment will come in later phases, so structure the codebase so those modules can slot in without refactoring the core"</em>), Milestone 1 encapsulates showtime selection behind the <code class="bg-velvet px-1.5 py-0.5 rounded text-marquee-gold font-mono text-xs">TicketingSlotInterface</code>.
                    </p>
                    
                    <div class="p-5 rounded-2xl bg-velvet border border-marquee-gold/30 space-y-3">
                        <div class="font-mono text-xs font-bold text-marquee-gold uppercase">PHP Contract Architecture:</div>
                        <pre class="bg-obsidian p-4 rounded-xl text-xs font-mono text-champagne overflow-x-auto"><code>namespace App\Contracts;

interface TicketingSlotInterface
{
    public function prepareSlotContext(Showtime $showtime): ShowtimeSlotContext;
    public function isSlotAvailable(Showtime $showtime): bool;
}</code></pre>
                        <p class="text-xs text-silver-screen leading-relaxed">
                            Clicking any showtime pill on the platform invokes <code class="bg-obsidian px-1 py-0.5 rounded text-marquee-gold font-mono">ShowtimeSlotPreviewController</code>, which retrieves the verified showtime, cinema, auditorium format, and pricing tier from MySQL, opening the <strong>Showtime Slot-In Preview Drawer</strong>. In Phase 2, a <code class="bg-obsidian px-1 py-0.5 rounded text-marquee-gold font-mono">SeatMapReservationService</code> can bind to this contract without touching the Movie or Cinema controllers.
                        </p>
                    </div>
                </section>

                <!-- 7. Simulations -->
                <section id="simulations" class="space-y-4 pt-6 border-t border-velvet-border">
                    <h2 class="font-display font-bold text-2xl text-champagne">7. Simulated External Dependencies & Disclosures</h2>
                    <ul class="list-disc list-inside space-y-2 text-xs sm:text-sm pl-2">
                        <li><strong>Video Trailer Player:</strong> Curated high-performance royalty-free theatrical MP4/WebM streams paired with an interactive Art-Deco canvas storyboard fallback.</li>
                        <li><strong>Geolocation Resolver:</strong> Deterministic city-center coordinates & Haversine distance calculator with 5 simulation presets.</li>
                        <li><strong>Studio Metadata Sync:</strong> Curated JSON fixture sync simulator supporting <code class="bg-velvet px-1 py-0.5 rounded text-emerald-open font-mono text-xs">success</code>, <code class="bg-velvet px-1 py-0.5 rounded text-amber-spotlight font-mono text-xs">partial</code>, and <code class="bg-velvet px-1 py-0.5 rounded text-rose-alert font-mono text-xs">timeout</code> outcomes with audit logging in MySQL.</li>
                        <li><strong>Email Notifications:</strong> Captured in <code class="bg-velvet px-1 py-0.5 rounded text-marquee-gold font-mono text-xs">simulated_notification_logs</code> table and displayed in member profile.</li>
                    </ul>
                </section>

                <!-- 8. Mandatory Customization Notice -->
                <section id="customization" class="pt-6 border-t border-velvet-border">
                    <div class="rounded-2xl bg-velvet border border-marquee-gold/40 p-6 sm:p-8 space-y-3 relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-marquee-gold/10 rounded-full blur-2xl pointer-events-none"></div>
                        <h3 class="font-display font-bold text-xl text-champagne">Need something more tailored?</h3>
                        <p class="text-xs sm:text-sm text-silver-screen leading-relaxed">
                            This demo showcases the current application features, kinetic animated catalog, and multi-city cinema discovery workflows. The web application can be further developed, extended, and customized to fit your business processes and specific cinema chain requirements. Features, workflows, interface, and ticketing integrations can be discussed and tailored to your needs.
                        </p>
                        <div class="pt-2 text-xs font-medium flex items-center gap-2">
                            <span class="text-silver-screen/80">Direct Contact:</span>
                            <a href="mailto:nixresponding@gmail.com" 
                               class="inline-flex items-center gap-1.5 text-marquee-gold hover:text-champagne underline underline-offset-4 font-mono font-bold transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                nixresponding@gmail.com
                            </a>
                        </div>
                    </div>
                </section>

            </div>
        </div>

    </div>

</x-dynamic-component>
