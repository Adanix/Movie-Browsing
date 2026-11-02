<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Curation Backoffice — Matinee Cinema Platform' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-obsidian text-silver-screen font-sans antialiased min-h-screen flex flex-col"
      x-data="{ 
          sidebarOpen: false,
          toast: {{ session()->has('status_toast') ? json_encode(session('status_toast')) : 'null' }}
      }"
      @show-toast.window="toast = $event.detail; setTimeout(() => toast = null, 4500)"
      x-init="if (toast) setTimeout(() => toast = null, 4500)">

    <!-- Top Navigation Bar -->
    <header class="bg-velvet border-b border-velvet-border h-16 sticky top-0 z-40 flex items-center justify-between px-3 sm:px-6 gap-2">
        <div class="flex items-center gap-2 sm:gap-4 min-w-0">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="md:hidden text-silver-screen hover:text-champagne p-2 rounded-lg bg-obsidian border border-velvet-border hover:border-marquee-gold/40 transition"
                    aria-label="Toggle Backoffice Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <a href="{{ route('manage.dashboard') }}" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-7 h-7 rounded bg-obsidian border border-marquee-gold/40 flex items-center justify-center text-marquee-gold text-xs font-mono font-bold">M</div>
                <span class="font-display font-extrabold text-base sm:text-lg text-champagne tracking-wider">MATINEE</span>
                <span class="px-2 py-0.5 rounded bg-sky-upcoming/15 text-sky-upcoming text-[10px] font-mono uppercase font-semibold hidden sm:inline-block">Backoffice</span>
            </a>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
            <a href="{{ route('public.home') }}" 
               class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-lg bg-obsidian border border-velvet-border hover:border-marquee-gold/40 text-silver-screen hover:text-champagne text-xs transition"
               title="View Public Site">
                <svg class="w-3.5 h-3.5 text-marquee-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span class="hidden sm:inline">View Public Site</span>
            </a>

            <div class="flex items-center gap-1.5 sm:gap-2 pl-2 sm:pl-3 border-l border-velvet-border text-xs">
                <span class="w-2 h-2 rounded-full flex-shrink-0 {{ auth()->user()->isAdmin() ? 'bg-sky-upcoming' : 'bg-emerald-open' }}"></span>
                <span class="text-champagne font-medium truncate max-w-[100px] sm:max-w-none">{{ auth()->user()->name }}</span>
                <span class="text-[10px] font-mono text-silver-screen/60 uppercase hidden md:inline">({{ auth()->user()->role }})</span>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="p-1.5 rounded-lg text-silver-screen hover:text-rose-alert hover:bg-rose-alert/10 transition" title="Log Out">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </header>

    <!-- Mobile Slide-Over Sidebar Drawer -->
    <div x-show="sidebarOpen" 
         class="md:hidden fixed inset-0 z-50 flex" 
         role="dialog" 
         aria-modal="true"
         style="display: none;">
        
        <!-- Backdrop -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-obsidian/80 backdrop-blur-sm"></div>

        <!-- Slide-over panel -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-in-out duration-200 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-150 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full"
             class="relative flex-1 flex flex-col max-w-xs w-full bg-velvet border-r border-velvet-border p-4 shadow-2xl overflow-y-auto">
            
            <!-- Drawer Header & Close Button -->
            <div class="flex items-center justify-between pb-4 border-b border-velvet-border mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded bg-obsidian border border-marquee-gold/40 flex items-center justify-center text-marquee-gold text-xs font-mono font-bold">M</div>
                    <span class="font-display font-extrabold text-base text-champagne tracking-wider">MATINEE</span>
                    <span class="px-2 py-0.5 rounded bg-sky-upcoming/15 text-sky-upcoming text-[10px] font-mono uppercase font-semibold">Backoffice</span>
                </div>
                <button type="button" @click="sidebarOpen = false" class="p-1 rounded-md text-silver-screen hover:text-champagne">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Mobile Nav Links -->
            <nav class="space-y-1.5 text-xs">
                <div class="px-2 text-[10px] uppercase font-mono tracking-wider text-silver-screen/50 mb-2">Management Console</div>
                <a href="{{ route('manage.dashboard') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('manage.dashboard') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet-raised' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Overview Dashboard</span>
                </a>

                @if(auth()->user()->isAdmin())
                <a href="{{ route('manage.movies.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('manage.movies.*') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet-raised' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                    <span>Movie Catalog (Admin)</span>
                </a>
                @endif

                <a href="{{ route('manage.cinemas.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('manage.cinemas.*') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet-raised' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Cinemas & Halls</span>
                </a>

                <a href="{{ route('manage.showtimes.index') }}" 
                   class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('manage.showtimes.*') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet-raised' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Showtime Scheduling</span>
                </a>
            </nav>

            <!-- Bottom User & Exit -->
            <div class="mt-auto pt-6 border-t border-velvet-border space-y-3">
                <a href="{{ route('public.home') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-obsidian border border-velvet-border text-silver-screen hover:text-champagne text-xs transition">
                    <svg class="w-4 h-4 text-marquee-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Return to Public Site</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2 rounded-lg text-rose-alert hover:bg-rose-alert/10 text-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Log Out ({{ auth()->user()->name }})</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="flex-1 flex overflow-hidden">
        <!-- Desktop Sidebar Navigation -->
        <aside class="w-64 bg-velvet border-r border-velvet-border flex-shrink-0 hidden md:block overflow-y-auto">
            <div class="p-4 space-y-6">
                <!-- Nav Section -->
                <div>
                    <div class="px-3 text-[10px] uppercase font-mono tracking-wider text-silver-screen/50 mb-2">Management Console</div>
                    <nav class="space-y-1 text-xs">
                        <a href="{{ route('manage.dashboard') }}" 
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->routeIs('manage.dashboard') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet-raised' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span>Overview Dashboard</span>
                        </a>

                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('manage.movies.index') }}" 
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->routeIs('manage.movies.*') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet-raised' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/></svg>
                            <span>Movie Catalog (Admin)</span>
                        </a>
                        @endif

                        <a href="{{ route('manage.cinemas.index') }}" 
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->routeIs('manage.cinemas.*') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet-raised' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Cinemas & Halls</span>
                        </a>

                        <a href="{{ route('manage.showtimes.index') }}" 
                           class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition {{ request()->routeIs('manage.showtimes.*') ? 'bg-marquee-gold/15 text-marquee-gold font-semibold' : 'text-silver-screen hover:text-champagne hover:bg-velvet-raised' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Showtime Scheduling</span>
                        </a>
                    </nav>
                </div>

                <!-- Simulation Info Panel -->
                <div class="p-3.5 rounded-xl bg-obsidian border border-velvet-border text-[11px] space-y-2">
                    <div class="font-mono text-marquee-gold uppercase font-bold text-[10px]">Backoffice Boundary</div>
                    <p class="text-silver-screen/70 leading-relaxed">
                        Managers are policy-restricted to their assigned cities (Jakarta & Bandung). Master film catalog is guarded for Lead Platform Curators.
                    </p>
                </div>
            </div>
        </aside>

        <!-- Main Content View Area -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8">
            <div class="max-w-7xl mx-auto">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Status Toast Notification -->
    <div x-show="toast" 
         x-transition
         class="fixed bottom-5 right-5 z-50 max-w-sm rounded-xl p-4 shadow-2xl border flex items-start gap-3 backdrop-blur-md"
         :class="{
             'bg-velvet border-emerald-open/50 text-emerald-open': toast?.type === 'success',
             'bg-velvet border-marquee-gold/50 text-marquee-gold': toast?.type === 'info',
             'bg-velvet border-amber-spotlight/50 text-amber-spotlight': toast?.type === 'warning',
             'bg-velvet border-rose-alert/50 text-rose-alert': toast?.type === 'error'
         }"
         style="display: none;">
        <div class="flex-1 text-xs">
            <div class="font-bold text-champagne" x-text="toast?.title || 'Notice'"></div>
            <div class="text-silver-screen mt-0.5 leading-relaxed" x-text="toast?.message"></div>
        </div>
        <button @click="toast = null" class="text-silver-screen hover:text-champagne text-sm p-0.5">×</button>
    </div>

</body>
</html>
