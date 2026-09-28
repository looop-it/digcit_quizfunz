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
            $seasonRankings = [];

            foreach ($this->rankingSeasons($global->ranking_season) as $season) {
                $seasonRankings[] = [
                    'id' => $season->id,
                    'name' => $season->name,
                    'rankings' => $this->boardsForSeason($season->id),
                ];
            }

            return view('ranking', compact(
                'preview',
                'seasonRankings',
            ));
        }

        return redirect()->route('home');
    }

    /**
     * Ranking boards for one season. Titles stay generic; the tab carries the season name.
     *
     * @param int $seasonId
     * @return array
     */
    private function boardsForSeason($seasonId)
    {
        $rankingData = (new RankingManager())->setSeasonId($seasonId)->getAllRanking();
        $rankings = [];

        if (!$rankingData) {
            return $rankings;
        }

        if (array_key_exists('personal_extra_ranking', $rankingData)) {
            $rankings[] = [
                'type' => 'weekly',
                'title' => '最強知識王',
                'ranks' => $rankingData['personal_extra_ranking'],
            ];
        }

        if (array_key_exists('personal_weekly', $rankingData)) {
            $weekRankings = array_slice($rankingData['personal_weekly'], -2, 2, true);

            foreach ($weekRankings as $yearWeek => $ranks) {
                $yearWeekArray = explode('_', $yearWeek);

                $date = now();
                $date->setISODate($yearWeekArray[0], $yearWeekArray[1]);

                $title = $date->startOfWeek()->format('d/m').'-'.$date->endOfWeek()->format('d/m');

                $rankings[] = [
                    'type' => 'weekly',
                    'title' => "每周最強知識王（{$title}）",
                    'ranks' => $ranks,
                ];
            }
        }

        if (array_key_exists('participate_count', $rankingData)) {
            $rankings[] = [
                'type' => 'participation',
                'title' => '最具人氣學校',
                'ranks' => $rankingData['participate_count'],
            ];
        }

        if (array_key_exists('accumulate_score', $rankingData)) {
            $rankings[] = [
                'type' => 'accumulate',
                'title' => '最傑出學校表現',
                'ranks' => $rankingData['accumulate_score'],
            ];
        }

        return $rankings;
    }

    /**
     * Seasons whose rankings should appear, in the order typed.
     *
     * @param string|int|null $value
     * @return \Illuminate\Support\Collection
     */
    private function rankingSeasons($value)
    {
        $ids = collect(explode(',', (string) $value))
            ->map(function ($id) {
                return intval(trim($id));
            })
            ->filter()
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            $latest = Season::whereIn('status', ['open', 'closed'])->latest()->first();

            return $latest ? collect([$latest]) : collect();
        }

        $seasons = Season::whereIn('id', $ids->all())->get()->keyBy('id');

        return $ids->map(function ($id) use ($seasons) {
            return $seasons->get($id);
        })->filter()->values();
    }
}
