<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnOffUserStatusMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()){
            $user = Auth::user(); 
            $user->is_online = true; 
            $user->last_active = now(); 
            $user->save();
        }
        return $next($request);
    }
}

// php artisan make:middleware OnOffUserStatusMid
