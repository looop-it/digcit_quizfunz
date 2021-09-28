<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class Middleware
{
    protected function getUserPaperId()
    {
        $user = Auth::user();
        $paperId = $user->getCurrentPaperId() ?? null;

        return $paperId;
    }
}
