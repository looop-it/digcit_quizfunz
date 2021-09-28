<?php

namespace App\Http\Middleware\Competition;

use Closure;
use App\Facades\PaperManager;
use App\Http\Middleware\Middleware;

class CheckPaperTimeout extends Middleware
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
        $paperId = $this->getUserPaperId();

        if (PaperManager::boot($paperId)->isPaperTimeout()) {
            return response()->json([
                'status' => 422,
                'message' => 'Paper has been timeout.'
            ], 200);
        }

        return $next($request);
    }
}
