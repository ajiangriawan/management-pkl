<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Ambil role user yang sedang login
        $userRole = Auth::user()->role;

        // Cek apakah role user termasuk dalam daftar role yang diperbolehkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
