<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserStatController extends Controller
{
    /**
     * Store user stats.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        try {
            $data = $request->all();

            $data['ip'] = $request->ip();

            Redis::connection('user_stats')->rpush("user:{$user->id}:stats", serialize($data));

            return response()->json([
                'status' => 200,
                'message' => 'User stat has been stored.'
            ], 200);
        } catch (\Exception $exception) {
            \Log::error("Failed to store user stat to cache. Error: {$exception->getMessage()}");
        }

        return response()->json([
            'status' => 422,
            'message' => 'Failed to store stat.'
        ], 422);
    }
}
