<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserIdleTimeoutMiddleware
{

    const TIMEOUT_SECONDS = 15 * 60;

    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && Auth::user()->role === 'user') {
            $lastActivity = $request->session()->get('last_user_activity_time');

            if ($lastActivity && (time() - $lastActivity) > self::TIMEOUT_SECONDS) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('home')->with('info', 'Sesi Anda telah berakhir secara otomatis karena tidak ada aktivitas selama 15 menit. Silakan masuk kembali.');
            }

            $request->session()->put('last_user_activity_time', time());
        }

        return $next($request);
    }
}
