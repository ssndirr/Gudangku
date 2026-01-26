<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // jika user tidak login atau role tidak cocok, blokir akses
        if (!$user || !in_array($user->role, $roles)) {
            // redirect ke home atau halaman lain, bisa tambahkan flash message
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
