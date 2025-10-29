<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Middleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        return $next($request);
    }
}
