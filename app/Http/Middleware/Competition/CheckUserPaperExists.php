<?php

namespace App\Http\Middleware\Competition;

use Closure;
use App\Facades\PaperManager;
use App\Http\Middleware\Middleware;

class CheckUserPaperExists extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $action)
    {
        $paperId = $this->getUserPaperId();
        
        if ($action == 'initialize') {
            // There is a processing paper.
            if ($paperId) {
                $paperManager = PaperManager::boot($paperId);

                return response()->json(
                    $paperManager->buildInitializeResponse(),
                    200
                );
            }
        } else {
            // Cached paper id was cleared dute to reasons like clean-timeout command.
            if (!$paperId) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No processing paper found.'
                ], 200);
            }
        }
        
        return $next($request);
    }
}
