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
        $preview = false;

        if ($request->has('previewkey') && $request->previewkey == env('RANKING_PREVIEW_KEY', '123456')) {
            $preview = true;
        }

        $global = GlobalRepository::getGlobal();

        if ($global->rank_status == 1 || $preview == true) {
            if ($global->ranking_season) {
                $season = Season::find(intval($global->ranking_season));
            } else {
                $season = Season::whereIn('status', ['open', 'closed'])->latest()->first();
            }

            $rankingData = (new RankingManager())->setSeasonId($season->id)->getAllRanking();
            
            $rankings = [];

            // Get weekly rankings
            $currentYear = Carbon::now()->year;
            $currentWeek = Carbon::now()->weekOfYear;

            $weekRangeOfCurrentYear = config('competition.weekly_ranking_range')[$currentYear];

            if (array_key_exists($currentWeek, $rankingData['personal_weekly']['secondary'])) {
                $week = $weekRangeOfCurrentYear[$currentWeek];
    
                $title = date_format(date_create($week['start_date']), 'm/d') . "-" . date_format(date_create($week['end_date']), 'm/d');
    
                array_push($rankings, [
                    'type' => 'weekly',
                    'title' => "每周最強知識王（{$title}）",
                    'ranks' => $rankingData['personal_weekly']['secondary'][($currentWeek)]
                ]);
            }

            if ($currentWeek > 1) {
                $currentWeek -= 1;
    
                if (array_key_exists($currentWeek, $rankingData['personal_weekly']['secondary'])) {
                    $week = $weekRangeOfCurrentYear[$currentWeek];
    
                    $title = date_format(date_create($week['start_date']), 'm/d') . "-" . date_format(date_create($week['end_date']), 'm/d');
    
                    array_push($rankings, [
                        'type' => 'weekly',
                        'title' => "每周最強知識王（{$title}）",
                        'ranks' => $rankingData['personal_weekly']['secondary'][($currentWeek)]
                    ]);
                }
            }

            if ($rankingData['participate_count']['secondary']) {
                array_push($rankings, [
                    'type' => 'participation',
                    'title' => "最具人氣學校",
                    'ranks' => $rankingData['participate_count']['secondary']
                ]);
            }

            if ($rankingData['accumulate_score']['secondary']) {
                array_push($rankings, [
                    'type' => 'accumulate',
                    'title' => "最傑出學校表現",
                    'ranks' => $rankingData['accumulate_score']['secondary']
                ]);
            }

            return view('ranking', compact(
                'preview',
                'rankings',
            ));
        }

        return redirect()->route('home');
    }
}
