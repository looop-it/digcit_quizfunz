<?php

namespace App\Http\Middleware\Competition;

use Closure;
use Illuminate\Support\Facades\Auth;

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
