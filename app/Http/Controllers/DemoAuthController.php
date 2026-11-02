<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DemoActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DemoAuthController extends Controller
{
    public function showLogin(): View
    {
        $personas = config('demo.personas', []);
        return view('demo.login', compact('personas'));
    }

    public function quickLogin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'persona_key' => 'required|string|in:visitor_member,cinema_manager,platform_admin',
        ]);

        $personaKey = $validated['persona_key'];
        $mappedEmail = config("demo.personas.{$personaKey}.email");

        if (!$mappedEmail) {
            return back()->withErrors(['persona_key' => 'Unrecognized demo persona key.']);
        }

        $user = User::where('email', $mappedEmail)
            ->where('is_demo_user', true)
            ->firstOrFail();

        Auth::login($user, false);
        $request->session()->regenerate();

        if ($user->preferred_city_id) {
            $request->session()->put('active_city_id', $user->preferred_city_id);
        }

        DemoActivityLog::create([
            'user_id' => $user->id,
            'persona_key' => $personaKey,
            'event_type' => 'quick_login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'payload_json' => [
                'role' => $user->role,
                'logged_in_at' => now()->toIso8601String(),
            ],
            'created_at' => now(),
        ]);

        $defaultRoute = config("demo.personas.{$personaKey}.default_route", 'movies.index');
        $personaName = config("demo.personas.{$personaKey}.name", 'Member');

        return redirect()->route($defaultRoute)->with('status_toast', [
            'type' => 'success',
            'title' => "Welcome, {$personaName}!",
            'message' => "Logged in as " . config("demo.personas.{$personaKey}.badge") . " without password.",
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $persona = Auth::user()?->persona_key;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($persona) {
            DemoActivityLog::create([
                'user_id' => $userId,
                'persona_key' => $persona,
                'event_type' => 'logout',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'payload_json' => ['logged_out_at' => now()->toIso8601String()],
                'created_at' => now(),
            ]);
        }

        if (config('demo.enabled', true)) {
            return redirect()->route('demo.login')->with('status_toast', [
                'type' => 'info',
                'title' => 'Session Terminated',
                'message' => 'You have logged out. Select another persona to continue testing.',
            ]);
        }

        return redirect()->route('public.home');
    }
}
