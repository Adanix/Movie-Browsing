<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Matinee — Multi-City Cinema Browsing & Animated Catalog' }}</title>
    <meta name="description" content="Discover movies, trailers, and showtimes across Jakarta, Bandung, Surabaya, Bali, and Missoula on Matinee — The Art-Deco Cinema Discovery Platform.">

    <!-- Fonts: Cinzel & Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-obsidian text-silver-screen font-sans antialiased selection:bg-marquee-gold selection:text-obsidian min-h-screen flex flex-col overflow-x-hidden"
      x-data="{ 
          mobileNav: false, 
          cityModal: false, 
          personaDropdown: false,
          toast: {{ session()->has('status_toast') ? json_encode(session('status_toast')) : 'null' }}
      }"
      @show-toast.window="toast = $event.detail; setTimeout(() => toast = null, 4500)"
      x-init="if (toast) setTimeout(() => toast = null, 4500)">

    <!-- 0. P0 Top Demo Persona Ribbon (Guarded by config('demo.enabled')) -->
    @if(config('demo.enabled', true))
    <div class="bg-velvet border-b border-velvet-border text-xs px-3 sm:px-6 py-1.5 flex items-center justify-between gap-2 z-50">
        <div class="flex items-center gap-2 min-w-0">
            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-marquee-gold/15 text-marquee-gold font-mono font-medium tracking-wide flex-shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-marquee-gold animate-pulse"></span>
                DEMO MODE
            </span>
            <span class="hidden md:inline text-silver-screen/80 text-[11px] truncate">
                Milestone 1 Cinema Browsing & Animated Catalog Platform · External Services Simulated
            </span>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
            <!-- Active Persona Badge & Quick Switcher -->
            @auth
                <div class="relative">
                    <button @click="personaDropdown = !personaDropdown" 
                            class="inline-flex items-center gap-1.5 sm:gap-2 px-2 sm:px-2.5 py-1 rounded bg-velvet-raised border border-velvet-border hover:border-marquee-gold/40 text-champagne text-xs transition max-w-[170px] sm:max-w-none">
                        <span class="w-2 h-2 rounded-full flex-shrink-0 {{ auth()->user()->isAdmin() ? 'bg-sky-upcoming' : (auth()->user()->isManager() ? 'bg-emerald-open' : 'bg-marquee-gold') }}"></span>
                        <span class="font-medium truncate">{{ auth()->user()->name }}</span>
                        <span class="text-silver-screen/60 text-[10px] hidden sm:inline">({{ auth()->user()->role }})</span>
                        <svg class="w-3.5 h-3.5 text-silver-screen transition-transform flex-shrink-0" :class="{'rotate-180': personaDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Persona Dropdown Menu -->
                    <div x-show="personaDropdown" 
                         @click.outside="personaDropdown = false"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-1 w-64 max-w-[calc(100vw-1.5rem)] rounded-lg bg-velvet-raised border border-velvet-border shadow-2xl p-2 z-50 space-y-1"
                         style="display: none;">
                        <div class="px-2 py-1 text-[10px] uppercase tracking-wider text-silver-screen/60 font-mono">Switch Demo Persona</div>
                        @foreach(config('demo.personas', []) as $key => $p)
                            <form action="{{ route('demo.quick-login') }}" method="POST">
                                @csrf
                                <input type="hidden" name="persona_key" value="{{ $key }}">
                                <button type="submit" class="w-full text-left px-2.5 py-1.5 rounded hover:bg-velvet flex items-center justify-between text-xs transition {{ auth()->user()->persona_key === $key ? 'bg-marquee-gold/10 text-marquee-gold font-medium' : 'text-silver-screen' }}">
                                    <span>{{ $p['name'] }}</span>
                                    <span class="text-[10px] font-mono opacity-60">{{ $p['badge'] }}</span>
                                </button>
                            </form>
                        @endforeach
                        <div class="border-t border-velvet-border my-1"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-2.5 py-1.5 rounded hover:bg-rose-alert/10 text-rose-alert text-xs transition flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Switch to Unauthenticated Guest
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('demo.login') }}" class="inline-flex items-center gap-1.5 text-marquee-gold hover:text-champagne font-medium transition text-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span class="hidden xs:inline">Quick Login</span>
                    <span class="xs:hidden">Personas</span>
                </a>
            @endauth

            <a href="{{ route('public.docs') }}" class="text-silver-screen hover:text-champagne transition border-l border-velvet-border pl-2.5 sm:pl-3 hidden sm:inline">
                Docs & Architecture
            </a>
        </div>
    </div>
    @endif

    <!-- 1. Main Theatrical Art-Deco Header -->
    <header class="sticky top-0 z-40 bg-obsidian/95 backdrop-blur-md border-b border-velvet-border">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 sm:gap-4">
            
            <!-- Left: Wordmark Brand + City Selector Pill -->
            <div class="flex items-center gap-2 sm:gap-4 min-w-0">
                <a href="{{ route('public.home') }}" class="group flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded bg-velvet border border-marquee-gold/40 flex items-center justify-center text-marquee-gold shadow-[0_0_15px_rgba(245,197,24,0.15)] group-hover:border-marquee-gold group-hover:shadow-[0_0_20px_rgba(245,197,24,0.3)] transition">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19.82 2H4.18C2.97 2 2 2.97 2 4.18v15.64C2 21.03 2.97 22 4.18 22h15.64c1.21 0 2.18-.97 2.18-2.18V4.18C22 2.97 21.03 2 19.82 2zM7 2v20M17 2v20M2 12h20M2 7h5M2 17h5M17 7h5M17 17h5"/></svg>
                    </div>
                    <div>
                        <div class="font-display font-extrabold text-lg sm:text-xl tracking-[0.15em] sm:tracking-[0.2em] text-champagne group-hover:text-marquee-gold transition">
                            MATINEE
                        </div>
                        <div class="text-[9px] font-mono tracking-widest text-marquee-gold/80 uppercase -mt-0.5 hidden sm:block">
                            Premiere Circuit
                        </div>
                    </div>
                </a>

                <!-- Concise City Selector Pill (Opens Modal) -->
                <button type="button" 
                        @click="cityModal = true"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-full bg-velvet hover:bg-velvet-raised border border-marquee-gold/30 hover:border-marquee-gold text-xs text-champagne transition group cursor-pointer shadow-sm max-w-[130px] sm:max-w-none flex-shrink">
                    <span class="text-marquee-gold text-xs sm:text-sm flex-shrink-0">📍</span>
                    <span class="font-medium truncate">{{ $activeCity->name ?? 'Jakarta' }}</span>
                    <span class="text-silver-screen/50 text-[10px] hidden md:inline flex-shrink-0">· {{ $activeCity->cinemas_count ?? 4 }} Cinemas</span>
                    <svg class="w-3 h-3 text-silver-screen group-hover:text-marquee-gold transition-transform group-hover:translate-y-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
            </div>

            <!-- Middle / Nav Links (Desktop) -->
            <nav class="hidden lg:flex items-center gap-1 font-medium text-sm">
                <a href="{{ route('movies.index') }}" 
                   class="px-3.5 py-2 rounded-md transition {{ request()->routeIs('movies.index') && !request()->has('release_status') ? 'text-marquee-gold bg-velvet font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet/50' }}">
                    Catalog
                </a>
                <a href="{{ route('movies.index', ['release_status' => 'now_showing']) }}" 
                   class="px-3.5 py-2 rounded-md transition {{ request()->query('release_status') === 'now_showing' ? 'text-marquee-gold bg-velvet font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet/50' }}">
                    Now Showing
                </a>
                <a href="{{ route('movies.index', ['release_status' => 'coming_soon']) }}" 
                   class="px-3.5 py-2 rounded-md transition {{ request()->query('release_status') === 'coming_soon' ? 'text-marquee-gold bg-velvet font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet/50' }}">
                    Coming Soon
                </a>
                <a href="{{ route('cinemas.index') }}" 
                   class="px-3.5 py-2 rounded-md transition {{ request()->routeIs('cinemas.*') ? 'text-marquee-gold bg-velvet font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet/50' }}">
                    Cinemas
                </a>
                <a href="{{ route('public.docs') }}" 
                   class="px-3.5 py-2 rounded-md transition {{ request()->routeIs('public.docs') ? 'text-marquee-gold bg-velvet font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet/50' }}">
                    Docs
                </a>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center gap-1.5 sm:gap-3 flex-shrink-0">
                <!-- Watchlist Button -->
                <a href="{{ route('watchlist.index') }}" 
                   class="relative p-2 rounded-lg bg-velvet hover:bg-velvet-raised border border-velvet-border text-silver-screen hover:text-marquee-gold transition"
                   title="My Watchlist">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    <span class="watchlist-counter-badge absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-marquee-gold text-obsidian text-[10px] font-mono font-bold rounded-full flex items-center justify-center">
                        {{ $watchlistCount ?? 0 }}
                    </span>
                </a>

                @auth
                    @if(auth()->user()->isManager())
                        <a href="{{ auth()->user()->isAdmin() ? route('manage.dashboard') : route('manage.cinemas.index') }}" 
                           class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-velvet-raised border border-marquee-gold/40 hover:border-marquee-gold text-champagne text-xs font-medium transition shadow-sm">
                            <svg class="w-4 h-4 text-marquee-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Backoffice</span>
                        </a>
                    @endif
                @else
                    <a href="{{ route('demo.login') }}" 
                       class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-medium text-xs tracking-wide transition shadow-md">
                        <span>Try Personas</span>
                    </a>
                @endauth

                <!-- Mobile Hamburger Toggle -->
                <button type="button" 
                        @click="mobileNav = !mobileNav"
                        class="p-2 rounded-lg lg:hidden bg-velvet text-silver-screen hover:text-champagne hover:bg-velvet-raised focus:outline-none transition"
                        aria-label="Toggle Navigation">
                    <svg x-show="!mobileNav" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileNav" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileNav" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden border-b border-velvet-border bg-obsidian/98 backdrop-blur-xl px-4 pt-3 pb-6 space-y-4 shadow-2xl max-h-[calc(100vh-5rem)] overflow-y-auto"
             style="display: none;">

            <!-- Quick Film Search in Mobile Drawer -->
            <form action="{{ route('movies.index') }}" method="GET" class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search movies, directors..." 
                       class="w-full pl-9 pr-4 py-2 rounded-lg bg-velvet border border-velvet-border focus:border-marquee-gold focus:ring-1 focus:ring-marquee-gold text-champagne placeholder-silver-screen/50 text-xs transition">
                <svg class="w-4 h-4 text-silver-screen/60 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </form>

            <!-- Active City Selection Card in Drawer -->
            <div class="p-3 rounded-xl bg-velvet border border-velvet-border flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <span class="text-marquee-gold text-sm">📍</span>
                    <div>
                        <div class="text-[10px] uppercase font-mono text-silver-screen/50">Active City</div>
                        <div class="font-bold text-champagne">{{ $activeCity->name ?? 'Jakarta' }}</div>
                    </div>
                </div>
                <button type="button" @click="mobileNav = false; cityModal = true" class="px-2.5 py-1 rounded bg-obsidian border border-velvet-border text-marquee-gold hover:text-champagne font-medium text-xs transition">
                    Change City →
                </button>
            </div>

            <!-- Main Nav Links with Active State -->
            <div class="space-y-1 text-sm font-medium">
                <a href="{{ route('movies.index') }}" 
                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('movies.index') && !request()->has('release_status') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold border-l-2 border-marquee-gold' : 'text-champagne hover:bg-velvet' }}">
                    Animated Catalog
                </a>
                <a href="{{ route('movies.index', ['release_status' => 'now_showing']) }}" 
                   class="block px-3 py-2 rounded-lg transition {{ request()->query('release_status') === 'now_showing' ? 'bg-marquee-gold/15 text-marquee-gold font-semibold border-l-2 border-marquee-gold' : 'text-champagne hover:bg-velvet' }}">
                    Now Showing
                </a>
                <a href="{{ route('movies.index', ['release_status' => 'coming_soon']) }}" 
                   class="block px-3 py-2 rounded-lg transition {{ request()->query('release_status') === 'coming_soon' ? 'bg-marquee-gold/15 text-marquee-gold font-semibold border-l-2 border-marquee-gold' : 'text-champagne hover:bg-velvet' }}">
                    Coming Soon
                </a>
                <a href="{{ route('cinemas.index') }}" 
                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('cinemas.*') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold border-l-2 border-marquee-gold' : 'text-champagne hover:bg-velvet' }}">
                    Cinemas Directory
                </a>
                <a href="{{ route('public.docs') }}" 
                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('public.docs') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold border-l-2 border-marquee-gold' : 'text-champagne hover:bg-velvet' }}">
                    Feature & Architecture Docs
                </a>
                <a href="{{ route('watchlist.index') }}" 
                   class="block px-3 py-2 rounded-lg transition {{ request()->routeIs('watchlist.*') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold border-l-2 border-marquee-gold' : 'text-champagne hover:bg-velvet' }} flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-marquee-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        <span>My Watchlist</span>
                    </span>
                    <span class="px-2 py-0.5 rounded-full bg-marquee-gold/20 text-marquee-gold text-xs font-mono font-bold">{{ $watchlistCount ?? 0 }}</span>
                </a>
                @auth
                    @if(auth()->user()->isManager())
                        <a href="{{ auth()->user()->isAdmin() ? route('manage.dashboard') : route('manage.cinemas.index') }}" 
                           class="block px-3 py-2 rounded-lg bg-sky-upcoming/10 text-sky-upcoming hover:bg-sky-upcoming/20 font-semibold border-l-2 border-sky-upcoming">
                            Curation Backoffice →
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Integrated Demo Persona Switcher in Mobile Drawer -->
            @if(config('demo.enabled', true))
            <div class="pt-3 border-t border-velvet-border">
                <div class="text-[10px] uppercase tracking-wider font-mono text-silver-screen/50 mb-2 px-1">
                    Demo Personas (One-Click)
                </div>
                <div class="grid grid-cols-1 gap-1.5">
                    @foreach(config('demo.personas', []) as $key => $p)
                        <form action="{{ route('demo.quick-login') }}" method="POST">
                            @csrf
                            <input type="hidden" name="persona_key" value="{{ $key }}">
                            <button type="submit" 
                                    class="w-full text-left px-3 py-2 rounded-lg text-xs transition flex items-center justify-between {{ auth()->check() && auth()->user()->persona_key === $key ? 'bg-marquee-gold/15 text-marquee-gold font-bold border border-marquee-gold/30' : 'bg-velvet text-silver-screen hover:text-champagne border border-velvet-border' }}">
                                <span class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ $key === 'platform_admin' ? 'bg-sky-upcoming' : ($key === 'cinema_manager' ? 'bg-emerald-open' : 'bg-marquee-gold') }}"></span>
                                    <span>{{ $p['name'] }}</span>
                                </span>
                                <span class="text-[10px] font-mono opacity-60 uppercase">{{ $p['badge'] }}</span>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Auth / Logout Action -->
            <div class="pt-2 border-t border-velvet-border">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-rose-alert hover:bg-rose-alert/10 text-xs font-medium transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Log Out ({{ auth()->user()->name }})</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('demo.login') }}" class="block w-full text-center py-2.5 rounded-lg bg-marquee-gold text-obsidian font-bold text-xs uppercase tracking-wider shadow-lg">
                        Select Demo Persona
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main View Content Area -->
    <main class="flex-grow">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- 2. Public Theatrical Footer with Customization Notice & nixresponding@gmail.com -->
    <footer class="bg-obsidian border-t border-velvet-border pt-16 pb-12 mt-20 text-silver-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Customization Notice Box (Mandatory P0 Contract) -->
            <div class="rounded-xl bg-velvet border border-marquee-gold/30 p-6 sm:p-8 mb-14 relative overflow-hidden">
                <div class="absolute -right-12 -top-12 w-48 h-48 bg-marquee-gold/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="max-w-3xl">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-marquee-gold/15 text-marquee-gold font-mono text-xs uppercase tracking-wider mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-marquee-gold"></span>
                        Customization & Business Solutions
                    </span>
                    <h3 class="font-display text-xl sm:text-2xl text-champagne font-bold mb-2">
                        Need something more tailored?
                    </h3>
                    <p class="text-sm leading-relaxed text-silver-screen mb-4">
                        This demo showcases the current application features, kinetic animated catalog, and multi-city cinema discovery workflows. The web application can be further developed, extended, and customized to fit your business processes and specific cinema chain requirements. Features, workflows, interfaces, and ticketing integrations can be discussed and tailored to your needs.
                    </p>
                    <div class="flex items-center gap-2 text-sm font-medium">
                        <span class="text-silver-screen/80">Direct Contact:</span>
                        <a href="mailto:nixresponding@gmail.com" 
                           class="inline-flex items-center gap-1.5 text-marquee-gold hover:text-champagne underline underline-offset-4 font-mono transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            nixresponding@gmail.com
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Columns -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-velvet-border text-sm">
                <div class="space-y-3 md:col-span-1">
                    <div class="font-display font-bold text-lg text-champagne tracking-wider">MATINEE</div>
                    <p class="text-xs text-silver-screen/70 leading-relaxed">
                        Multi-city theatrical discovery, fluid animated catalog, and showtime platform. Built with Laravel 13, MySQL, and Tailwind CSS v4.
                    </p>
                    <div class="text-xs font-mono text-marquee-gold/80">
                        Active City: {{ $activeCity->name ?? 'Jakarta' }}
                    </div>
                </div>

                <div>
                    <h4 class="font-display text-champagne font-semibold text-xs uppercase tracking-wider mb-4">Discovery</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('movies.index') }}" class="hover:text-marquee-gold transition">Animated Catalog</a></li>
                        <li><a href="{{ route('movies.index', ['release_status' => 'now_showing']) }}" class="hover:text-marquee-gold transition">Now Showing</a></li>
                        <li><a href="{{ route('movies.index', ['release_status' => 'coming_soon']) }}" class="hover:text-marquee-gold transition">Coming Soon</a></li>
                        <li><a href="{{ route('cinemas.index') }}" class="hover:text-marquee-gold transition">Cinema Venues</a></li>
                        <li><a href="{{ route('watchlist.index') }}" class="hover:text-marquee-gold transition">Member Watchlist</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-display text-champagne font-semibold text-xs uppercase tracking-wider mb-4">Cities & Lore</h4>
                    <ul class="space-y-2 text-xs">
                        @foreach($allCities as $c)
                            <li>
                                <form action="{{ route('city.select') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="city_slug" value="{{ $c->slug }}">
                                    <button type="submit" class="hover:text-marquee-gold transition text-left cursor-pointer {{ $activeCity && $activeCity->id === $c->id ? 'text-marquee-gold font-medium' : '' }}">
                                        {{ $c->name }}
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h4 class="font-display text-champagne font-semibold text-xs uppercase tracking-wider mb-4">Demo & Evaluator</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('demo.login') }}" class="hover:text-marquee-gold transition">Persona Quick Login</a></li>
                        <li><a href="{{ route('public.docs') }}" class="hover:text-marquee-gold transition">Product & Architecture Docs</a></li>
                        <li><a href="{{ route('public.docs') }}#phase2" class="hover:text-marquee-gold transition">Phase 2 Slot-In Boundary</a></li>
                        <li><a href="mailto:nixresponding@gmail.com" class="text-marquee-gold hover:text-champagne transition font-mono">nixresponding@gmail.com</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright & Disclosures -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-silver-screen/50 gap-4">
                <div>
                    © 2026 Matinee Cinema Platform · Inspired by the Freeframe Matinee Architecture.
                </div>
                <div class="flex items-center gap-4">
                    <span class="font-mono text-[11px]">PHP 8.5 · Laravel 13 · Tailwind CSS v4</span>
                    <a href="mailto:nixresponding@gmail.com" class="hover:text-marquee-gold transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 3. Interactive City Selector Modal (#city-selector-modal) -->
    <div x-show="cityModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="city-modal-title" 
         role="dialog" 
         aria-modal="true" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:p-0">
            <!-- Backdrop -->
            <div x-show="cityModal" 
                 @click="cityModal = false"
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-obsidian/80 backdrop-blur-md transition-opacity"></div>

            <!-- Modal Panel -->
            <div x-show="cityModal" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0 scale-95" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100 scale-100" 
                 x-transition:leave-end="opacity-0 scale-95" 
                 class="inline-block w-full max-w-2xl p-6 sm:p-8 my-8 text-left align-middle transition-all transform bg-velvet border border-marquee-gold/30 rounded-2xl shadow-2xl relative">
                
                <div class="flex items-center justify-between pb-4 border-b border-velvet-border mb-6">
                    <div>
                        <h3 class="font-display font-bold text-xl text-champagne" id="city-modal-title">
                            Select Your Screening City
                        </h3>
                        <p class="text-xs text-silver-screen mt-0.5">
                            Switching city updates nearby cinema venues, distances, and local movie schedules.
                        </p>
                    </div>
                    <button @click="cityModal = false" class="text-silver-screen hover:text-champagne p-1 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- City Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                    @foreach($allCities as $c)
                        <form action="{{ route('city.select') }}" method="POST">
                            @csrf
                            <input type="hidden" name="city_slug" value="{{ $c->slug }}">
                            <button type="submit" 
                                    class="w-full text-left p-3.5 rounded-xl border transition flex items-center justify-between group cursor-pointer {{ $activeCity && $activeCity->id === $c->id ? 'bg-marquee-gold/10 border-marquee-gold text-champagne' : 'bg-velvet-raised border-velvet-border hover:border-marquee-gold/40 text-silver-screen hover:text-champagne' }}">
                                <div>
                                    <div class="font-display font-bold text-sm group-hover:text-marquee-gold transition flex items-center gap-1.5">
                                        <span>{{ $c->name }}</span>
                                        @if($activeCity && $activeCity->id === $c->id)
                                            <span class="w-1.5 h-1.5 rounded-full bg-marquee-gold"></span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-silver-screen/70 mt-0.5 line-clamp-1">{{ $c->tagline }}</div>
                                </div>
                                <div class="text-right pl-2">
                                    <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-obsidian text-marquee-gold border border-velvet-border">
                                        {{ $c->currency_code }}
                                    </span>
                                </div>
                            </button>
                        </form>
                    @endforeach
                </div>

                <!-- Geolocation Simulator Presets Box -->
                <div class="p-4 rounded-xl bg-obsidian border border-velvet-border">
                    <div class="text-xs font-mono uppercase text-marquee-gold tracking-wider mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Simulate Geolocation ("Detect Nearest City")</span>
                    </div>
                    <p class="text-xs text-silver-screen/80 mb-3">
                        Choose a simulated coordinate preset below to calculate exact Haversine distances to circuit auditoriums:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        @foreach(\App\Services\Simulators\SimulatedGeolocationService::PRESETS as $presetKey => $preset)
                            <form action="{{ route('city.select') }}" method="POST">
                                @csrf
                                <input type="hidden" name="preset_key" value="{{ $presetKey }}">
                                <button type="submit" class="w-full text-left p-2 rounded bg-velvet hover:bg-velvet-raised border border-velvet-border hover:border-marquee-gold/40 text-silver-screen hover:text-champagne transition flex items-center justify-between">
                                    <span class="truncate">{{ $preset['name'] }}</span>
                                    <span class="text-[10px] text-marquee-gold font-mono ml-2">Simulate →</span>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 4. Interactive Theatrical Trailer Modal (#trailer-modal) -->
    <div x-data x-show="$store.trailerModal.isOpen"
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog" 
         aria-modal="true" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 text-center sm:p-0">
            <!-- Backdrop -->
            <div @click="$store.trailerModal.close()" class="fixed inset-0 bg-obsidian/90 backdrop-blur-md transition-opacity"></div>

            <!-- Modal Panel -->
            <div class="inline-block w-full max-w-4xl p-4 sm:p-6 my-8 text-left align-middle bg-velvet border border-marquee-gold/30 rounded-2xl shadow-2xl relative overflow-hidden">
                <div class="flex items-center justify-between pb-3 border-b border-velvet-border mb-4">
                    <div>
                        <h3 class="font-display font-bold text-lg text-champagne" x-text="$store.trailerModal.movie.title || 'Movie Trailer'"></h3>
                        <p class="text-xs text-silver-screen" x-text="($store.trailerModal.trailer.title || 'Official Theatrical Trailer') + ' · ' + ($store.trailerModal.movie.runtime || '')"></p>
                    </div>
                    <button @click="$store.trailerModal.close()" class="text-silver-screen hover:text-champagne p-1 rounded-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Video / Storyboard Container -->
                <div class="aspect-video w-full bg-obsidian rounded-xl overflow-hidden relative border border-velvet-border">
                    <template x-if="$store.trailerModal.loading">
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-marquee-gold gap-3">
                            <svg class="w-8 h-8 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="3" stroke-dasharray="32" stroke-linecap="round"/></svg>
                            <span class="text-xs font-mono tracking-widest uppercase">Loading Theatrical Stream...</span>
                        </div>
                    </template>

                    <template x-if="!$store.trailerModal.loading">
                        <video x-ref="trailerVideo" 
                               controls 
                               autoplay 
                               class="w-full h-full object-cover"
                               :src="$store.trailerModal.trailer.stream_url"
                               poster="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=1200&auto=format&fit=crop&q=80">
                            Your browser does not support HTML5 video.
                        </video>
                    </template>
                </div>

                <!-- Storyboard Chapters Strip -->
                <div class="mt-4 pt-3 border-t border-velvet-border flex items-center justify-between text-xs text-silver-screen/80">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-marquee-gold/15 text-marquee-gold font-mono font-medium text-[10px]">
                            OFFICIAL THEATRICAL STREAM
                        </span>
                        <span class="hidden sm:inline" x-text="'Audio: ' + ($store.trailerModal.movie.audio_language || 'Original')"></span>
                    </div>
                    <div class="font-mono text-[11px] text-silver-screen/60">
                        <span x-text="$store.trailerModal.trailer.views || 0"></span> views logged
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Phase 2 Showtime Slot-In Drawer (#showtime-slot-drawer) -->
    <div x-data x-show="$store.showtimeDrawer.isOpen" 
         class="fixed inset-0 z-50 overflow-hidden" 
         role="dialog" 
         aria-modal="true" 
         style="display: none;">
        <div class="absolute inset-0 overflow-hidden">
            <!-- Backdrop -->
            <div @click="$store.showtimeDrawer.close()" 
                 class="absolute inset-0 bg-obsidian/80 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div class="w-screen max-w-md bg-velvet border-l border-marquee-gold/30 p-6 flex flex-col justify-between shadow-2xl relative overflow-y-auto">
                    
                    <!-- Drawer Header -->
                    <div>
                        <div class="flex items-center justify-between pb-4 border-b border-velvet-border">
                            <div>
                                <span class="px-2 py-0.5 rounded bg-marquee-gold/15 text-marquee-gold font-mono font-semibold text-[10px] tracking-wider uppercase">
                                    Showtime Verified
                                </span>
                                <h3 class="font-display font-bold text-lg text-champagne mt-1">Showtime & Phase 2 Slot-In</h3>
                            </div>
                            <button @click="$store.showtimeDrawer.close()" class="text-silver-screen hover:text-champagne p-1 rounded-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <!-- Loading State -->
                        <template x-if="$store.showtimeDrawer.loading">
                            <div class="py-16 text-center text-marquee-gold">
                                <svg class="w-8 h-8 animate-spin mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="3" stroke-dasharray="32" stroke-linecap="round"/></svg>
                                <span class="text-xs font-mono tracking-widest uppercase">Verifying Showtime Slot...</span>
                            </div>
                        </template>

                        <!-- Verified Slot Content -->
                        <template x-if="!$store.showtimeDrawer.loading && $store.showtimeDrawer.slot">
                            <div class="mt-6 space-y-6">
                                <!-- Movie & Time Card -->
                                <div class="p-4 rounded-xl bg-obsidian border border-velvet-border space-y-3">
                                    <div class="font-display font-bold text-base text-champagne" x-text="$store.showtimeDrawer.slot.movie.title"></div>
                                    <div class="flex items-center justify-between text-xs font-mono text-marquee-gold">
                                        <span x-text="$store.showtimeDrawer.slot.schedule.date"></span>
                                        <span class="text-base font-bold" x-text="$store.showtimeDrawer.slot.schedule.starts_at"></span>
                                    </div>
                                    <div class="text-xs text-silver-screen flex items-center gap-1.5 pt-2 border-t border-velvet-border">
                                        <span class="text-marquee-gold">🏛️</span>
                                        <span x-text="$store.showtimeDrawer.slot.cinema.name + ' (' + $store.showtimeDrawer.slot.cinema.city + ')'"></span>
                                    </div>
                                    <div class="text-xs text-silver-screen/80">
                                        <span x-text="$store.showtimeDrawer.slot.auditorium.name"></span> · 
                                        <span class="text-champagne font-medium" x-text="$store.showtimeDrawer.slot.auditorium.format"></span>
                                    </div>
                                </div>

                                <!-- Pricing & Seats Summary -->
                                <div class="grid grid-cols-2 gap-3 text-xs">
                                    <div class="p-3 rounded-lg bg-velvet-raised border border-velvet-border">
                                        <div class="text-[10px] text-silver-screen/60 uppercase font-mono">Base Ticket Tier</div>
                                        <div class="text-base font-bold text-marquee-gold font-mono mt-0.5" x-text="$store.showtimeDrawer.slot.pricing.formatted"></div>
                                    </div>
                                    <div class="p-3 rounded-lg bg-velvet-raised border border-velvet-border">
                                        <div class="text-[10px] text-silver-screen/60 uppercase font-mono">Available Seats</div>
                                        <div class="text-base font-bold text-champagne font-mono mt-0.5" x-text="$store.showtimeDrawer.slot.seats.available_estimate + ' / ' + $store.showtimeDrawer.slot.auditorium.capacity"></div>
                                    </div>
                                </div>

                                <!-- Phase 2 Architectural Disclosure Badge -->
                                <div class="p-4 rounded-xl bg-marquee-gold/10 border border-marquee-gold/30 text-xs text-silver-screen space-y-2">
                                    <div class="flex items-center gap-2 font-mono font-bold text-marquee-gold text-[11px] uppercase">
                                        <svg class="w-4 h-4 text-marquee-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        <span>Phase 2 Slot-In Ready</span>
                                    </div>
                                    <p class="leading-relaxed text-[11px]">
                                        In strict accordance with the Milestone 1 brief, seat reservation and payment checkout are decoupled. The validated showtime payload is ready to plug into the Phase 2 <code class="bg-obsidian px-1 py-0.5 rounded text-marquee-gold">TicketingSlotInterface</code>.
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-2 pt-2">
                                    <a :href="'/movies/' + $store.showtimeDrawer.slot.movie.slug + '/calendar.ics?showtime_id=' + $store.showtimeDrawer.slot.showtime_id" 
                                       class="w-full py-2.5 rounded-lg bg-velvet-raised hover:bg-velvet border border-marquee-gold/40 text-champagne hover:text-marquee-gold font-medium text-xs flex items-center justify-center gap-2 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>Add to Calendar (.ics)</span>
                                    </a>

                                    <button type="button" 
                                            @click="$store.watchlist.toggle($store.showtimeDrawer.slot.movie.id)" 
                                            class="w-full py-2.5 rounded-lg bg-marquee-gold text-obsidian hover:bg-amber-spotlight font-bold text-xs flex items-center justify-center gap-2 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                                        <span>Save Movie to Watchlist</span>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Close footer -->
                    <div class="pt-6 border-t border-velvet-border">
                        <button type="button" 
                                @click="$store.showtimeDrawer.close()" 
                                class="w-full py-2 rounded bg-obsidian text-silver-screen hover:text-champagne text-xs transition">
                            Close Preview
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- 6. Floating Status Toast Notifications -->
    <div x-show="toast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:translate-x-4"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed bottom-5 right-5 z-50 max-w-sm rounded-xl p-4 shadow-2xl border flex items-start gap-3 backdrop-blur-md"
         :class="{
             'bg-velvet border-emerald-open/50 text-emerald-open': toast?.type === 'success',
             'bg-velvet border-marquee-gold/50 text-marquee-gold': toast?.type === 'info',
             'bg-velvet border-amber-spotlight/50 text-amber-spotlight': toast?.type === 'warning',
             'bg-velvet border-rose-alert/50 text-rose-alert': toast?.type === 'error'
         }"
         style="display: none;">
        <div class="flex-shrink-0 mt-0.5">
            <template x-if="toast?.type === 'success'">
                <svg class="w-5 h-5 text-emerald-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </template>
            <template x-if="toast?.type !== 'success'">
                <svg class="w-5 h-5 text-marquee-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </template>
        </div>
        <div class="flex-1 text-xs">
            <div class="font-bold text-champagne" x-text="toast?.title || 'Notice'"></div>
            <div class="text-silver-screen mt-0.5 leading-relaxed" x-text="toast?.message"></div>
        </div>
        <button @click="toast = null" class="text-silver-screen hover:text-champagne text-sm p-0.5">×</button>
    </div>

</body>
</html>
