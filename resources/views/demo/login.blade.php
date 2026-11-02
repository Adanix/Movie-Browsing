<x-dynamic-component :component="'layouts.public'" title="Select Persona — Matinee Demo">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        
        <div class="text-center max-w-2xl mx-auto mb-14 space-y-3">
            <span class="px-3 py-1 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase font-bold tracking-widest">
                Passwordless Demo Access
            </span>
            <h1 class="font-display font-black text-3xl sm:text-5xl text-champagne tracking-wide marquee-glow">
                Step Into the Matinee Demo
            </h1>
            <p class="text-xs sm:text-sm text-silver-screen/80 leading-relaxed">
                Choose an allowlisted persona below to explore the public browsing experience, member watchlist, or cinema & catalog curation backoffice—no password required.
            </p>
        </div>

        <!-- 3 Persona Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($personas as $key => $p)
                <div class="rounded-2xl bg-velvet border border-velvet-border hover:border-marquee-gold/50 p-6 sm:p-8 flex flex-col justify-between transition-all duration-300 shadow-xl group relative overflow-hidden">
                    
                    <!-- Top Ribbon -->
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-marquee-gold/40 to-transparent group-hover:via-marquee-gold transition"></div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="w-12 h-12 rounded-xl bg-obsidian border border-velvet-border flex items-center justify-center font-display font-bold text-lg text-marquee-gold group-hover:border-marquee-gold transition">
                                {{ $p['avatar_initials'] ?? 'M' }}
                            </span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase tracking-wider {{ $key === 'platform_admin' ? 'bg-sky-upcoming/15 text-sky-upcoming' : ($key === 'cinema_manager' ? 'bg-emerald-open/15 text-emerald-open' : 'bg-marquee-gold/15 text-marquee-gold') }}">
                                {{ $p['badge'] }}
                            </span>
                        </div>

                        <div>
                            <h3 class="font-display font-bold text-xl text-champagne group-hover:text-marquee-gold transition">
                                {{ $p['name'] }}
                            </h3>
                            <div class="text-xs font-mono text-silver-screen/60 mt-0.5">
                                {{ $p['title'] }}
                            </div>
                        </div>

                        <p class="text-xs text-silver-screen/80 leading-relaxed pt-2 border-t border-velvet-border">
                            {{ $p['description'] }}
                        </p>
                    </div>

                    <!-- Action Submit Button -->
                    <div class="pt-6 mt-6 border-t border-velvet-border">
                        <form action="{{ route('demo.quick-login') }}" method="POST">
                            @csrf
                            <input type="hidden" name="persona_key" value="{{ $key }}">
                            <button type="submit" 
                                    class="w-full py-3 rounded-xl bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs uppercase tracking-wider transition shadow-lg flex items-center justify-center gap-1.5 cursor-pointer">
                                <span>{{ $p['button_label'] }}</span>
                                <span>→</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Guest link -->
        <div class="text-center pt-4 border-t border-velvet-border/60">
            <span class="text-xs text-silver-screen/60">Or proceed without an account: </span>
            <a href="{{ route('movies.index') }}" class="text-xs text-marquee-gold hover:text-champagne font-medium underline underline-offset-4 ml-1 transition">
                Continue as Unauthenticated Guest Visitor →
            </a>
        </div>

    </div>

</x-dynamic-component>
