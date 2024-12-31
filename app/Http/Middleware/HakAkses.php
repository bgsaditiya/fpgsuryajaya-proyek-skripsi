<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HakAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $jenis): Response
    {
        if (auth()->user()->jenis == $jenis) {
            return $next($request);
        }
        return response()->json(['Maaf halaman ini tidak dapat akses...!']);
    }
}
