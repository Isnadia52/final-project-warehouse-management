<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            // Jika user belum login, redirect ke login
            return redirect('/login');
        }

        if (! in_array($request->user()->role, $roles)) {
            // Jika role user tidak ada dalam daftar roles yang diizinkan
            abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}