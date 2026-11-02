<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovieCalendarController extends Controller
{
    public function download(Movie $movie, Request $request): Response
    {
        $showtimeId = $request->query('showtime_id');
        $showtime = null;
        if ($showtimeId) {
            $showtime = Showtime::with(['cinema', 'auditorium'])->find($showtimeId);
        }

        if ($showtime) {
            $summary = "🎬 Matinee Screening: {$movie->title} at {$showtime->cinema->name}";
            $description = "Film: {$movie->title}\\nFormat: {$showtime->presentation_format}\\nCinema: {$showtime->cinema->name}\\nAuditorium: {$showtime->auditorium->name}\\nAddress: {$showtime->cinema->address_line}\\n\\nBooked/Saved via Matinee Cinema Platform.";
            $location = "{$showtime->cinema->name}, {$showtime->cinema->address_line}";
            $dtStart = $showtime->starts_at->setTimezone('UTC')->format('Ymd\THis\Z');
            $dtEnd = $showtime->ends_at ? $showtime->ends_at->setTimezone('UTC')->format('Ymd\THis\Z') : $showtime->starts_at->copy()->addMinutes($movie->runtime_minutes)->setTimezone('UTC')->format('Ymd\THis\Z');
            $uid = "showtime-{$showtime->id}@matinee.ramadadawah.my.id";
            $filename = "matinee-screening-{$movie->slug}.ics";
        } else {
            $summary = "🎬 Premiere Release: {$movie->title} (Matinee Circuit)";
            $description = "Official Theatrical Premiere of {$movie->title}. Directed by " . ($movie->director_name ?: 'Matinee Director') . ".\\nTagline: {$movie->tagline}";
            $location = "Matinee Premiere Theaters";
            $dtStart = $movie->release_date->copy()->setTime(10, 0, 0)->setTimezone('UTC')->format('Ymd\THis\Z');
            $dtEnd = $movie->release_date->copy()->setTime(23, 0, 0)->setTimezone('UTC')->format('Ymd\THis\Z');
            $uid = "release-{$movie->id}@matinee.ramadadawah.my.id";
            $filename = "matinee-premiere-{$movie->slug}.ics";
        }

        $now = gmdate('Ymd\THis\Z');

        $ics = "BEGIN:VCALENDAR\r\n" .
               "VERSION:2.0\r\n" .
               "PRODID:-//Matinee Premiere Cinema Network//EN\r\n" .
               "CALSCALE:GREGORIAN\r\n" .
               "METHOD:PUBLISH\r\n" .
               "BEGIN:VEVENT\r\n" .
               "UID:{$uid}\r\n" .
               "DTSTAMP:{$now}\r\n" .
               "DTSTART:{$dtStart}\r\n" .
               "DTEND:{$dtEnd}\r\n" .
               "SUMMARY:{$summary}\r\n" .
               "DESCRIPTION:{$description}\r\n" .
               "LOCATION:{$location}\r\n" .
               "STATUS:CONFIRMED\r\n" .
               "END:VEVENT\r\n" .
               "END:VCALENDAR\r\n";

        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
