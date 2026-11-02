<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Contracts\TicketingSlotInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ShowtimeSlotPreviewController extends Controller
{
    public function show(Showtime $showtime, Request $request, TicketingSlotInterface $slotService): View|JsonResponse
    {
        $slotContext = $slotService->prepareSlotContext($showtime);

        if ($request->wantsJson()) {
            return response()->json($slotContext->toArray());
        }

        return view('components.showtime-slot-drawer', [
            'slot' => $slotContext,
            'showtime' => $showtime,
        ]);
    }
}
