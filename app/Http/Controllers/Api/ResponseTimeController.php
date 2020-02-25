<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ResponseTime;

class ResponseTimeController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        try {
            ResponseTime::create([
                'user_id' => $user->id,
                'time' => $request->time,
                'user_agent' => $request->user_agent ?? null
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Response time has been stored.'
            ], 200);
        } catch (\Exception $exception) {
            \Log::error("Failed to create response time record. Error: {$exception->getMessage()}. Data:" . json_encode($request->all()));
        }

        return response()->json([
            'status' => 422,
            'message' => 'Failed to response time.'
        ], 422);
    }
}
