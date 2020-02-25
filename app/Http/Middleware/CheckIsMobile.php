<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Facades\Agent;

class CheckIsMobile
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
        if (!Agent::isTablet() && !Agent::isDesktop()) {
            return redirect()->route('competition.error')->with('message', '比賽系統現只支援桌面電腦、手提電腦或平板電腦。');
        }

        return $next($request);
    }
}
