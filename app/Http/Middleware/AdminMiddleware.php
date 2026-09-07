<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Not signed in, or not an admin
        if (!$user || $user->user_type !== 'Admin') {
            Auth::logout();
            return redirect('login')->with('msg', 'Admin login required');
        }

        // Account has been deactivated by another admin
        if ($user->account_status !== 'Active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('login')->with('msg', 'Your account has been deactivated. Please contact an administrator.');
        }

        return $next($request);
    }
}
