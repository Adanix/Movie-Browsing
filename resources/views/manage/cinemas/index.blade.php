@extends('layouts.manage', [
    'title' => 'Manage Cinemas & Auditoriums — Matinee Cinema Platform'
])

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-display font-bold text-2xl text-champagne tracking-wide">Cinemas & Venues</h1>
            <p class="text-silver-screen/70 text-xs mt-1">
                Manage theatrical flagship palaces, auditoriums, sound specs, and operational hours.
            </p>
        </div>
        <div class="text-xs text-silver-screen/60 font-mono">
            Showing {{ $cinemas->count() }} of {{ $cinemas->total() }} venues
        </div>
    </div>

    <!-- Cinema Cards / Table -->
    <div class="rounded-xl bg-velvet border border-velvet-border overflow-hidden shadow-2xl">
        <div class="p-4 border-b border-velvet-border flex items-center justify-between text-xs">
            <span class="font-mono text-silver-screen/60">Registered Venues</span>
            <span class="text-silver-screen/50 text-[11px]">Role: {{ auth()->user()->role }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs divide-y divide-velvet-border">
                <thead class="bg-obsidian/60 text-silver-screen/70 font-mono text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Cinema / Palace</th>
                        <th class="py-3 px-3">City & District</th>
                        <th class="py-3 px-3">Halls & Capacity</th>
                        <th class="py-3 px-3">Architectural Style</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-velvet-border">
                    @forelse($cinemas as $cinema)
                        <tr class="hover:bg-velvet-raised/50 transition">
                            <td class="py-3 px-4">
                                <div class="font-bold text-champagne flex items-center gap-2">
                                    <span>{{ $cinema->name }}</span>
                                    @if($cinema->hero_badge)
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-mono bg-marquee-gold/15 text-marquee-gold font-medium">
                                            {{ $cinema->hero_badge }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-silver-screen/50 mt-0.5">{{ $cinema->address_line }}</div>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                <div class="text-champagne font-medium">{{ $cinema->city->name ?? '—' }}</div>
                                <div class="text-silver-screen/50 text-[11px]">{{ $cinema->neighborhood }}</div>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                <div class="font-mono text-champagne">{{ $cinema->auditoriums->count() }} Auditoriums</div>
                                <div class="text-silver-screen/50 text-[11px]">{{ number_format($cinema->auditoriums->sum('total_capacity')) }} Seats</div>
                            </td>
                            <td class="py-3 px-3">
                                <span class="text-silver-screen/80">{{ $cinema->architectural_style ?? 'Art-Deco Streamline' }}</span>
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                @if($cinema->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-open/15 text-emerald-open text-[10px] font-mono font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-open"></span> Operational
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-rose-alert/15 text-rose-alert text-[10px] font-mono font-medium">
                                        Temporarily Closed
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('cinemas.show', $cinema->slug) }}" target="_blank"
                                       class="p-1.5 rounded bg-velvet-raised hover:bg-velvet border border-velvet-border text-silver-screen hover:text-champagne transition"
                                       title="View Public Page">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>

                                    @can('update', $cinema)
                                    <a href="{{ route('manage.cinemas.edit', $cinema) }}"
                                       class="p-1.5 rounded bg-velvet-raised hover:bg-velvet border border-velvet-border text-silver-screen hover:text-marquee-gold transition"
                                       title="Edit Cinema Settings">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-silver-screen/50">
                                No cinemas registered for your current authorization scope.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($cinemas->hasPages())
            <div class="p-4 border-t border-velvet-border bg-obsidian/30">
                {{ $cinemas->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
