<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $isAdminPanel = str_starts_with($request->path(), 'administrator');

        // Jika guest mencoba akses admin panel
        if ($user && $user->hasRole('guest') && $isAdminPanel) {
            return redirect('/beranda');
        }

        // Redirect setelah login
        if ($request->is('administrator/login') && $user) {
            return match(true) {
                $user->hasRole('admin', 'teknis') => redirect('/administrator'),
                $user->hasRole('guest') => redirect('/beranda'),
                default => $next($request)
            };
        }

        return $next($request);
    }
}
