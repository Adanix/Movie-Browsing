@extends('layouts.manage', [
    'title' => 'Showtime Scheduling & Slot Control — Matinee Cinema Platform'
])

@section('content')
<div class="space-y-8" 
     x-data="{
         selectedCinemaId: '{{ old('cinema_id', $cinemas->first()->id ?? '') }}',
         auditoriumsMap: {{ json_encode($cinemas->mapWithKeys(fn($c) => [$c->id => $c->auditoriums->map(fn($a) => ['id' => $a->id, 'name' => $a->name, 'format' => $a->projection_type, 'capacity' => $a->total_capacity])])) }},
         selectedAuditoriumId: '{{ old('auditorium_id', '') }}'
     }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-display font-bold text-2xl text-champagne tracking-wide">Showtime Scheduling</h1>
            <p class="text-silver-screen/70 text-xs mt-1">
                Schedule theatrical screenings with automated double-booking & turnaround conflict checks.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-open/15 text-emerald-open text-xs font-mono">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-open animate-pulse"></span>
                Conflict Engine Active
            </span>
        </div>
    </div>

    <!-- Error Summary Alert -->
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-alert/15 border border-rose-alert/40 text-rose-alert text-xs space-y-1">
            <div class="font-bold flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Showtime Conflict or Validation Warning:</span>
            </div>
            <ul class="list-disc pl-5 space-y-0.5 text-silver-screen">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 1. Schedule New Showtime Form Card -->
    <div class="rounded-xl bg-velvet border border-velvet-border p-6 shadow-2xl">
        <h2 class="text-sm font-bold text-marquee-gold font-mono uppercase tracking-wider mb-4 border-b border-velvet-border pb-2 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Schedule New Theatrical Screening</span>
        </h2>

        <form action="{{ route('manage.showtimes.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Film Select -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-silver-screen mb-1">Film Title <span class="text-rose-alert">*</span></label>
                    <select name="movie_id" required class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <option value="">Select a Film...</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ old('movie_id') == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }} ({{ $movie->runtime_minutes }}m · {{ $movie->age_rating }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cinema Palace Select -->
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Cinema Palace <span class="text-rose-alert">*</span></label>
                    <select name="cinema_id" x-model="selectedCinemaId" required class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <option value="">Select Cinema...</option>
                        @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}">
                                {{ $cinema->name }} ({{ $cinema->city->name ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Auditorium / Hall Select (Dynamic by Cinema) -->
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Auditorium / Hall <span class="text-rose-alert">*</span></label>
                    <select name="auditorium_id" required class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <option value="">Select Hall...</option>
                        <template x-for="hall in (auditoriumsMap[selectedCinemaId] || [])" :key="hall.id">
                            <option :value="hall.id" x-text="hall.name + ' (' + hall.format + ' · ' + hall.capacity + ' seats)'" :selected="hall.id == selectedAuditoriumId"></option>
                        </template>
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Screening Date <span class="text-rose-alert">*</span></label>
                    <input type="date" name="screening_date" value="{{ old('screening_date', now()->format('Y-m-d')) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <!-- Start Time -->
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Start Time (24h) <span class="text-rose-alert">*</span></label>
                    <input type="time" name="start_time" value="{{ old('start_time', '19:30') }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <!-- Presentation Format -->
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Projection / Sound Format <span class="text-rose-alert">*</span></label>
                    <select name="presentation_format" required class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        <option value="IMAX with Laser" {{ old('presentation_format') == 'IMAX with Laser' ? 'selected' : '' }}>IMAX with Laser</option>
                        <option value="Dolby Cinema Atmos" {{ old('presentation_format') == 'Dolby Cinema Atmos' ? 'selected' : '' }}>Dolby Cinema Atmos</option>
                        <option value="70mm Film Print" {{ old('presentation_format') == '70mm Film Print' ? 'selected' : '' }}>70mm Film Print</option>
                        <option value="4DX Immersive" {{ old('presentation_format') == '4DX Immersive' ? 'selected' : '' }}>4DX Immersive</option>
                        <option value="Standard 2D Laser" {{ old('presentation_format') == 'Standard 2D Laser' ? 'selected' : '' }}>Standard 2D Laser</option>
                        <option value="ScreenX 270°" {{ old('presentation_format') == 'ScreenX 270°' ? 'selected' : '' }}>ScreenX 270°</option>
                    </select>
                </div>

                <!-- Pricing Tier -->
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Pricing Tier <span class="text-rose-alert">*</span></label>
                    <select name="pricing_tier_id" required class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                        @foreach($pricingTiers as $tier)
                            <option value="{{ $tier->id }}" {{ old('pricing_tier_id') == $tier->id ? 'selected' : '' }}>
                                {{ $tier->name }} (Rp {{ number_format($tier->base_price) }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Accessibility Badges -->
            <div class="pt-2 border-t border-velvet-border flex flex-wrap gap-4 text-xs">
                <span class="text-silver-screen/60 font-mono text-[11px] self-center">Accessibility:</span>

                <label class="inline-flex items-center gap-1.5 cursor-pointer text-silver-screen hover:text-champagne">
                    <input type="checkbox" name="is_captioned_cc" value="1" {{ old('is_captioned_cc') ? 'checked' : '' }}
                           class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                    <span class="px-1.5 py-0.5 rounded bg-obsidian border border-velvet-border font-mono text-[10px]">CC</span>
                    <span>Closed Captions</span>
                </label>

                <label class="inline-flex items-center gap-1.5 cursor-pointer text-silver-screen hover:text-champagne">
                    <input type="checkbox" name="is_audio_described_ad" value="1" {{ old('is_audio_described_ad') ? 'checked' : '' }}
                           class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                    <span class="px-1.5 py-0.5 rounded bg-obsidian border border-velvet-border font-mono text-[10px]">AD</span>
                    <span>Audio Description</span>
                </label>

                <label class="inline-flex items-center gap-1.5 cursor-pointer text-silver-screen hover:text-champagne">
                    <input type="checkbox" name="is_sensory_friendly_sf" value="1" {{ old('is_sensory_friendly_sf') ? 'checked' : '' }}
                           class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                    <span class="px-1.5 py-0.5 rounded bg-obsidian border border-velvet-border font-mono text-[10px]">SF</span>
                    <span>Sensory Friendly</span>
                </label>

                <label class="inline-flex items-center gap-1.5 cursor-pointer text-silver-screen hover:text-champagne">
                    <input type="checkbox" name="is_parent_baby_pb" value="1" {{ old('is_parent_baby_pb') ? 'checked' : '' }}
                           class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                    <span class="px-1.5 py-0.5 rounded bg-obsidian border border-velvet-border font-mono text-[10px]">PB</span>
                    <span>Parent & Baby</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-3 border-t border-velvet-border flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-marquee-gold text-obsidian font-bold text-xs hover:bg-amber-spotlight transition shadow-lg shadow-marquee-gold/20 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Commit Showtime to Schedule</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 2. Existing Showtimes Table with Filters -->
    <div class="rounded-xl bg-velvet border border-velvet-border overflow-hidden shadow-2xl">
        <div class="p-4 border-b border-velvet-border flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-bold text-champagne text-sm">Scheduled Theatrical Screenings</h3>
                <p class="text-silver-screen/50 text-[11px] mt-0.5">Showing rolling showtimes across assigned venues</p>
            </div>

            <!-- Filter Controls -->
            <form method="GET" action="{{ route('manage.showtimes.index') }}" class="flex items-center gap-2">
                <select name="cinema_id" onchange="this.form.submit()" class="px-2.5 py-1.5 rounded-lg bg-obsidian border border-velvet-border text-silver-screen text-xs focus:border-marquee-gold">
                    <option value="">All Cinemas</option>
                    @foreach($cinemas as $c)
                        <option value="{{ $c->id }}" {{ request('cinema_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                       class="px-2.5 py-1.5 rounded-lg bg-obsidian border border-velvet-border text-silver-screen text-xs focus:border-marquee-gold">

                @if(request()->hasAny(['cinema_id', 'date']))
                    <a href="{{ route('manage.showtimes.index') }}" class="p-1.5 rounded bg-obsidian border border-velvet-border text-silver-screen hover:text-champagne text-xs" title="Reset Filters">
                        ✕
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs divide-y divide-velvet-border">
                <thead class="bg-obsidian/60 text-silver-screen/70 font-mono text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Screening Date & Time</th>
                        <th class="py-3 px-3">Film</th>
                        <th class="py-3 px-3">Cinema Palace & Hall</th>
                        <th class="py-3 px-3">Format & Audio</th>
                        <th class="py-3 px-3">Pricing Tier</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-velvet-border">
                    @forelse($showtimes as $st)
                        <tr class="hover:bg-velvet-raised/50 transition">
                            <td class="py-3 px-4 whitespace-nowrap">
                                <div class="font-mono font-bold text-champagne text-sm">
                                    {{ $st->starts_at->format('H:i') }}
                                </div>
                                <div class="text-[11px] text-silver-screen/60 font-mono">
                                    {{ $st->starts_at->format('D, d M Y') }}
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-bold text-champagne">{{ $st->movie->title ?? 'Untitled' }}</div>
                                <div class="text-[11px] text-silver-screen/50">
                                    {{ $st->movie->runtime_minutes ?? 0 }}m · {{ $st->movie->age_rating ?? 'SU' }}
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="text-champagne font-medium">{{ $st->cinema->name ?? '—' }}</div>
                                <div class="text-[11px] text-silver-screen/50">
                                    {{ $st->auditorium->name ?? 'Hall' }} ({{ $st->cinema->city->name ?? '' }})
                                </div>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-marquee-gold/15 text-marquee-gold text-[10px] font-mono font-semibold">
                                    {{ $st->presentation_format }}
                                </span>
                                <div class="flex items-center gap-1 mt-1 font-mono text-[10px] text-silver-screen/60">
                                    <span>{{ strtoupper($st->audio_language_code) }}</span>
                                    @if($st->is_captioned_cc)
                                        <span class="px-1 rounded bg-obsidian text-emerald-open">CC</span>
                                    @endif
                                    @if($st->is_audio_described_ad)
                                        <span class="px-1 rounded bg-obsidian text-sky-upcoming">AD</span>
                                    @endif
                                    @if($st->is_sensory_friendly_sf)
                                        <span class="px-1 rounded bg-obsidian text-amber-spotlight">SF</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                <div class="font-mono text-champagne">
                                    Rp {{ number_format($st->pricingTier->base_price ?? 50000) }}
                                </div>
                                <div class="text-[11px] text-silver-screen/50">
                                    {{ $st->pricingTier->name ?? 'Standard' }}
                                </div>
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <form action="{{ route('manage.showtimes.destroy', $st) }}" method="POST" onsubmit="return confirm('Cancel screening at {{ $st->starts_at->format('H:i') }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-1.5 rounded bg-velvet-raised hover:bg-rose-alert/20 border border-velvet-border text-silver-screen hover:text-rose-alert transition"
                                            title="Cancel Screening">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-silver-screen/50">
                                No showtimes scheduled matching the active criteria. Use the form above to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($showtimes->hasPages())
            <div class="p-4 border-t border-velvet-border bg-obsidian/30">
                {{ $showtimes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
