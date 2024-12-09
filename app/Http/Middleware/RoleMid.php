<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$role): Response
    {
        if(!Auth::check() || !Auth::user()->hasRoles($role)){
            // abort('403','Unauthorized form role middleware');
            return redirect()->back()->with('error','Unauthorize Role Access');
        }
        return $next($request);
    }
}
