<?php

namespace App\Http\Middleware\Competition;

use Closure;
use App\Models\Season;
use App\Models\Participant;
use App\Models\School;
use App\Models\Paper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Events\CompetitionStarted;

class VerifyParticipantInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user->participant) {
            return redirect()->route('participant.participate');
        }

        return $next($request);
    }
}
