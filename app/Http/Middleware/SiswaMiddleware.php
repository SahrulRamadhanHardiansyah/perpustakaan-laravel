<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         /** @var \App\Models\User $user */
            $user = Auth::user();

        if (Auth::check() && $user->isSiswa()) {
            return $next($request);
        }

        return redirect('/')->with('error', 'You do not have siswa access.');
    }
}
