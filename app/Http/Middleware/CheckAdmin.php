<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Mengecek apakah user sudah login DAN role-nya adalah 'admin'
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request); // Jika ya, izinkan lewat
        }

        // Jika bukan admin, lempar kembali ke halaman dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
    }
}