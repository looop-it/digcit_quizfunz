<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Season;

class CheckTimeInterval
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

        $paper = $user->papers()
                    ->inSeason($season->id)
                    ->finished()
                    ->orderBy('finished_at', 'desc')
                    ->first();

        if ($paper) {
            $minutesLapsed = now()->diffInMinutes($paper->finished_at);

            if ($minutesLapsed < $season->time_interval) {
                $minutesToWait = $season->time_interval - $minutesLapsed;

                $message = "您需要等待 <b>{$minutesToWait}分鐘</b> 才可再次挑戰。";

                return redirect()->route('competition.error')->with('message', $message);
            }
        }

        return $next($request);
    }
}
