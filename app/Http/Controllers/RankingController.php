<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Season;
use App\Repositories\GlobalRepository;
use Illuminate\Http\Request;
use App\Helpers\RankingManager;

class RankingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $global = GlobalRepository::getGlobal();

        if ($global->ranking_season) {
            $season = Season::find(intval($global->ranking_season));
        } else {
            $season = Season::whereIn('status', ['open', 'closed'])->latest()->first();
        }

        $weekly_ranking_range = config('competition.weekly_ranking_range');
        $weeks = array_keys($weekly_ranking_range);

        $current_week = Carbon::now()->weekOfYear;

        if (in_array($current_week, $weeks) == false) {
            // If current week > max week range, set current_week = max(weeks)
            if ($current_week > $weeks[0]) {
                $current_week = max($weeks);
            } else {
                $current_week = false;
            }
        }

        $seasonId = $global->ranking_season ?? (season()->id ?? 1);
        $rankingData = (new RankingManager())->setSeasonId($seasonId)->getAllRanking();

        $preview = false;
        $previewkey = $request->query('previewkey');
        if ($previewkey == env('RANKING_PREVIEW_KEY', '123456')) {
            $preview = true;
        }

        return view('home.rank', compact('season', 'weekly_ranking_range', 'current_week', 'preview', 'rankingData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
