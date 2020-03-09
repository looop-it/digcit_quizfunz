<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckDailyTimesLimit
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
        $season = season();

        if (!$user || !$season) {
            return redirect()->route('home');
        }

        try {
            $papers = $user->papers()
                        ->inSeason($season->id)
                        ->whereIn('status', ['reviewing', 'finished'])
                        ->whereDate('started_at', today()->format('Y-m-d'))
                        ->count();

            if ($papers > 0 && $papers >= $season->daily_times_limit) {
                $message = "抱歉，您已達到<b>{$season->name}</b>的每日最高參賽次數({$season->daily_times_limit}次)。";
    
                return redirect()->route('competition.error')->with('message', $message);
            }
        } catch (\Exception $exception) {
            $message = "系統故障，請重試！";

            return redirect()->route('competition.error')->with('message', $message);
        }

        return $next($request);
    }
}
