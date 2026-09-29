<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserIdleTimeoutMiddleware
{
    /**
     * Timeout duration in seconds (15 minutes).
     */
    const TIMEOUT_SECONDS = 15 * 60; // 900 seconds

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Khusus buat role 'user', jika sudah idle / tidak ada aktivitas selama 15 menit, auto logout
        if (Auth::check() && Auth::user()->role === 'user') {
            $lastActivity = $request->session()->get('last_user_activity_time');

            if ($lastActivity && (time() - $lastActivity) > self::TIMEOUT_SECONDS) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('info', 'Sesi Anda telah berakhir secara otomatis karena tidak ada aktivitas selama 15 menit. Silakan masuk kembali.');
            }

            // Update timestamp aktivitas terakhir
            $request->session()->put('last_user_activity_time', time());
        }

        return $next($request);
    }
}
