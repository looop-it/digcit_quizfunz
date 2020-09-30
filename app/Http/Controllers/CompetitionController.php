<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{
    /**
     * Start competition.
     *
     * @return void
     */
    public function start(Request $request)
    {
        return view('competition.start');
    }

    /**
     * Get result of paper finished.
     *
     * @return void
     */
    public function result()
    {
        return view('competition.result');
    }

    /**
     * Get finished paper records.
     *
     * @return void
     */
    public function getRecords()
    {
        $user = Auth::user();

        $papers = $user->papers()->with('season')->finished()->orderBy('started_at', 'desc')->get();

        $records = $papers->groupBy('season.name');

        return view('match_record')->with('records', $records);
    }

    public function error(Request $request)
    {
        if ($request->session()->has('message')) {
            return view('common.error')->with('message', $request->session()->get('message'));
        }

        return redirect()->route('home');
    }
}
