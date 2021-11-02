<?php

namespace App\Http\Controllers;

use App\Helpers\RankingManager;
use App\Models\Season;
use App\Repositories\GlobalRepository;
use Illuminate\Http\Request;

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

            if ($rankingData) {
                if (array_key_exists('personal_extra_ranking', $rankingData)) {
                    array_push($rankings, [
                        'type' => 'weekly',
                        'title' => '最強知識王',
                        'ranks' => $rankingData['personal_extra_ranking'],
                    ]);
                }

                // Get last two weeks ranking
                if (array_key_exists('personal_weekly', $rankingData)) {
                    $weekRankings = array_slice($rankingData['personal_weekly'], -2, 2, true);

                    foreach ($weekRankings as $yearWeek => $ranks) {
                        $yearWeekArray = explode('_', $yearWeek);

                        $date = now();
                        $date->setISODate($yearWeekArray[0], $yearWeekArray[1]);

                        $title = $date->startOfWeek()->format('d/m').'-'.$date->endOfWeek()->format('d/m');

                        array_push($rankings, [
                            'type' => 'weekly',
                            'title' => "每周最強知識王（{$title}）",
                            'ranks' => $ranks,
                        ]);
                    }
                }

                if (array_key_exists('participate_count', $rankingData)) {
                    array_push($rankings, [
                        'type' => 'participation',
                        'title' => '最具人氣學校',
                        'ranks' => $rankingData['participate_count'],
                    ]);
                }

                if (array_key_exists('accumulate_score', $rankingData)) {
                    array_push($rankings, [
                        'type' => 'accumulate',
                        'title' => '最傑出學校表現',
                        'ranks' => $rankingData['accumulate_score'],
                    ]);
                }
            }

            return view('ranking', compact(
                'preview',
                'rankings',
            ));
        }

        return redirect()->route('home');
    }
}
