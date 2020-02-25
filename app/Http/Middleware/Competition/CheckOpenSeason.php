<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Season;

class CheckOpenSeason
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
        $season = Season::open()->latest()->first();

        if (!$season) {
            return redirect()->route('competition.error')->with('message', '現時沒有開放的比賽，請密切留意最新消息。');
        }
        
        return $next($request);
    }
}
