<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAjax
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->json())
        {
            return response()->json([
                'error' => 'Invalid request type.'
            ], 400);
        }

        if (!Auth::check())
        {
            return response()->json([
                'error' => 'Unautorized'
            ], 401);
        }
        return $next($request);
    }
}
