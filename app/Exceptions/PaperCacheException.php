<?php

namespace App\Exceptions;

use Exception;

class PaperCacheException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        // Report to slack, sentry
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 500,
                'message' => "Failed to cache paper"
            ], 500);
        }
    }
}
