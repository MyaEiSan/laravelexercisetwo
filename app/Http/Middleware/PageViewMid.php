<?php

namespace App\Http\Middleware;

use App\Models\Pageview;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PageViewMid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $getpageurl = $request->url(); 
        $pageview = Pageview::firstOrCreate(['pageurl'=>$getpageurl]); 
        $pageview->increment('counter');

        return $next($request);
    }
}
