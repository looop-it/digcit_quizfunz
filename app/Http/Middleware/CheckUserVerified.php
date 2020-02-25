<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserVerified
{
    /**
     * Handle an incoming request.\
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        if (!$user->isVerified()) {
            return redirect()->route('user.not_verified');
        }
        
        return $next($request);
    }
}
