<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->level !== 'admin') {
            return redirect('/buku')->with('pesan', 'Anda tidak punya akses ke halaman tersebut');
        }

        return $next($request);
    }
}
