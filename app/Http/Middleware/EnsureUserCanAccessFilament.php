<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserCanAccessFilament
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect('/administrator/login');
        }

        $user = Auth::user();

        if (! in_array($user->role, ['admin', 'teknis'])) {
            Auth::logout();
            return redirect('/beranda')
                ->withErrors(['email' => 'Anda tidak memiliki akses ke panel admin.']);
        }

        return $next($request);
    }
    
}
