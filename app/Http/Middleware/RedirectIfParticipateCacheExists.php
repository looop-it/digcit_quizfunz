<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class RedirectIfParticipateCacheExists
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
        $user = Auth::user();

        if (!Cache::has("user:{$user->id}:participate")) {
            return redirect()->route('participant.participate');
        }
        
        return $next($request);
    }
}
