@extends('layouts.manage', [
    'title' => 'Edit ' . $cinema->name . ' — Matinee Cinema Platform'
])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb & Title -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-silver-screen/60 mb-1">
                <a href="{{ route('manage.cinemas.index') }}" class="hover:text-marquee-gold transition">Cinemas</a>
                <span>/</span>
                <span class="text-champagne">{{ $cinema->name }}</span>
            </div>
            <h1 class="font-display font-bold text-2xl text-champagne tracking-wide">Edit Cinema Venue</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('cinemas.show', $cinema->slug) }}" target="_blank" class="text-xs text-marquee-gold hover:underline flex items-center gap-1">
                <span>View Public Page</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
            <span class="text-silver-screen/40">·</span>
            <a href="{{ route('manage.cinemas.index') }}" class="text-xs text-silver-screen hover:text-champagne transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Back</span>
            </a>
        </div>
    </div>

    <!-- Error Summary Alert -->
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-alert/15 border border-rose-alert/40 text-rose-alert text-xs space-y-1">
            <div class="font-bold flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Please fix the following validation errors:</span>
            </div>
            <ul class="list-disc pl-5 space-y-0.5 text-silver-screen">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <form action="{{ route('manage.cinemas.update', $cinema) }}" method="POST" class="rounded-xl bg-velvet border border-velvet-border p-6 shadow-2xl space-y-6">
        @csrf
        @method('PUT')

        <!-- Core Venue Info -->
        <div>
            <h2 class="text-sm font-bold text-marquee-gold font-mono uppercase tracking-wider mb-4 border-b border-velvet-border pb-2">
                1. Venue Profile & Location
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Cinema Name <span class="text-rose-alert">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $cinema->name) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Neighborhood / District <span class="text-rose-alert">*</span></label>
                    <input type="text" name="neighborhood" value="{{ old('neighborhood', $cinema->neighborhood) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-silver-screen mb-1">Physical Address <span class="text-rose-alert">*</span></label>
                    <input type="text" name="address_line" value="{{ old('address_line', $cinema->address_line) }}" required
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Contact Phone</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $cinema->phone_number) }}"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Promotional Badge / Title</label>
                    <input type="text" name="hero_badge" value="{{ old('hero_badge', $cinema->hero_badge) }}"
                           placeholder="e.g. Flagship Palace, Grand Theatrical"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>
            </div>
        </div>

        <!-- Architecture & Hours -->
        <div>
            <h2 class="text-sm font-bold text-marquee-gold font-mono uppercase tracking-wider mb-4 border-b border-velvet-border pb-2">
                2. Architecture, Hours & Operational State
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-silver-screen mb-1">Architectural Style</label>
                    <input type="text" name="architectural_style" value="{{ old('architectural_style', $cinema->architectural_style) }}"
                           placeholder="e.g. Art-Deco Streamline Moderne"
                           class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-medium text-silver-screen mb-1">Open Time <span class="text-rose-alert">*</span></label>
                        <input type="text" name="open_time" value="{{ old('open_time', $cinema->opening_hours_json['open'] ?? '10:00') }}" required
                               class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs"
                               placeholder="10:00">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-silver-screen mb-1">Close Time <span class="text-rose-alert">*</span></label>
                        <input type="text" name="close_time" value="{{ old('close_time', $cinema->opening_hours_json['close'] ?? '23:30') }}" required
                               class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs"
                               placeholder="23:30">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-silver-screen mb-1">Transit & Valet / Parking Directions</label>
                    <textarea name="transit_and_parking_note" rows="3"
                              class="w-full px-3 py-2 rounded-lg bg-obsidian border border-velvet-border focus:border-marquee-gold text-champagne text-xs leading-relaxed">{{ old('transit_and_parking_note', $cinema->transit_and_parking_note) }}</textarea>
                </div>

                <div class="md:col-span-2 pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer text-xs text-silver-screen">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $cinema->is_active) ? 'checked' : '' }}
                               class="rounded bg-obsidian border-velvet-border text-marquee-gold focus:ring-0">
                        <span class="text-champagne font-medium">Cinema is actively accepting public showtimes and admissions</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Registered Auditoriums Overview (Readonly Reference) -->
        <div>
            <h2 class="text-sm font-bold text-silver-screen font-mono uppercase tracking-wider mb-3 border-b border-velvet-border pb-2">
                Auditoriums & Halls ({{ $cinema->auditoriums->count() }})
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($cinema->auditoriums as $hall)
                    <div class="p-3 rounded-lg bg-obsidian border border-velvet-border space-y-1 text-xs">
                        <div class="font-bold text-champagne flex items-center justify-between">
                            <span>{{ $hall->name }}</span>
                            <span class="px-1.5 py-0.5 rounded bg-marquee-gold/15 text-marquee-gold text-[10px] font-mono">
                                {{ $hall->projection_type }}
                            </span>
                        </div>
                        <div class="text-[11px] text-silver-screen/60">
                            Sound: {{ $hall->sound_system }} · {{ $hall->total_capacity }} Seats
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-4 border-t border-velvet-border flex items-center justify-between">
            <a href="{{ route('manage.cinemas.index') }}" class="px-4 py-2 rounded-lg bg-obsidian border border-velvet-border text-silver-screen hover:text-champagne text-xs transition">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 rounded-lg bg-marquee-gold text-obsidian font-bold text-xs hover:bg-amber-spotlight transition shadow-lg shadow-marquee-gold/20">
                Update Cinema
            </button>
        </div>

    </form>

</div>
@endsection
