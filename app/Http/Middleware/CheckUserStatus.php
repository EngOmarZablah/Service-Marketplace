<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        if ($request->user()->status === 'pending') {
            return response()->json(['error' => 'Account not activated.'], 403);
        }

        if ($request->user()->status === 'rejected') {
            return response()->json(['error' => 'Account has been rejected.'], 403);
        }
        return $next($request);
    }
}