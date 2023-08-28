<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!in_array($user->role, $roles)) {
            return redirect()->route('barang.index')->withErrors('Anda tidak memiliki izin akses');
        }

    return $next($request);
    }
}