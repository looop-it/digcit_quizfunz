<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Season;
use App\Admin\Widgets\RankingTable;
use App\Facades\RankingManager;
use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $this->seasonId = $request->season ?? latestSeason()->id;

        $rankingManager = RankingManager::setSeasonId(intval($this->seasonId));

        $this->rankingData = $rankingManager->getAllRanking();
        $this->lastUpdatedAt = $rankingManager->getLastUpdatedAt();

        $url = $request->fullUrlWithQuery(['type' => '_type_']);
        $type = $request->get('type', 'weekly');

        $content = Admin::content(function (Content $content) use ($url, $type) {
            $content->header('排行榜');
            $content->description('最後更新於'.$this->lastUpdatedAt);

            $content->row(function ($row) use ($url, $type) {
                $seasonId = $this->seasonId;
                $seasons = Season::whereIn('status', ['open', 'closed'])->get();
                $types = [
                    'weekly' => '每周排行榜',
                    'all' => '總排行榜',
                ];

                $row->column(
                    12,
                    new Box('選擇賽季', view('admin.ranking.season_button_group', compact('seasons', 'seasonId')))
                );
                $row->column(
                    12,
                    new Box('選擇排行榜', view('admin.ranking.type_button_group', compact('types', 'url', 'type')))
                );
            });

            switch ($type) {
                case 'all':
                    //Dashboard summary
                    $content->row(function ($row) {
                        $row->column(
                            6,
                            (
                                new Box(
                                    '學校出線排行榜',
                                    $this->schoolRankingTable()->render()
                                )
                            )->collapsable()->style('danger')
                        );
                        $row->column(
                            6,
                            (
                                new Box(
                                    '最強知識王（封神榜）',
                                    $this->personalExtraRankingTable()->render()
                                )
                            )->collapsable()->style('danger')
                        );
                        $row->column(
                            6,
                            (
                                new Box(
                                    '最傑出學校表現',
                                    $this->schoolAccumulateScoreRankingTable()->render()
                                )
                            )->collapsable()->style('info')
                        );

                        $row->column(
                            6,
                            (
                                new Box(
                                    '最具人氣學校',
                                    $this->schoolParticipationRateRankingTable()->render()
                                )
                            )->collapsable()->style('warning')
                        );

                        $row->column(
                            6,
                            (
                                new Box(
                                    '最強知識王者(最好成績)',
                                    $this->personalRankingTable()->render()
                                )
                            )->collapsable()->style('danger')
                        );

                        $row->column(
                            12,
                            (
                                new Box(
                                    '各校前3名',
                                    $this->schoolWinnerTable()->render()
                                )
                            )->collapsable()->style('danger')
                        );
                    });
                    break;

                case 'weekly':
                    $content->row(function ($row) {
                        $weeklyRankingData = $this->rankingData['personal_weekly'];

                        $weekCount = count($weeklyRankingData);

                        foreach (array_reverse($weeklyRankingData, true) as $yearWeek => $rankings) {
                            $yearWeekArray = explode('_', $yearWeek);
                            $date = now()->setISODate($yearWeekArray[0], $yearWeekArray[1]);
                            $startDate = $date->startOfWeek()->format('Y-m-d');
                            $endDate = $date->endOfWeek()->format('Y-m-d');

                            $title = "每周最強知識王<第{$weekCount}週>({$startDate}至{$endDate})";

                            $row->column(
                                6,
                                (
                                    new Box(
                                        $title,
                                        $this->personalWeeklyRankingTable($title, $yearWeek, $rankings)->render()
                                    )
                                )->collapsable()->style('danger')
                            );

                            --$weekCount;
                        }
                    });

                    break;
            }
        });

        unset($this->rankingData);

        return $content;
    }

    protected function schoolRankingTable()
    {
        $headers = ['排名', '學校名字', '成績', '前50平均得分', '前50平均用時（秒）', '參加比率%'];

        $data = [];
        $count = 0;

        if (isset($this->rankingData['school']) && count($this->rankingData['school'])) {
            foreach ($this->rankingData['school'] as $record) {
                $data[$count] = [
                    $this->rankingStyle($count + 1),
                    $record->name,
                    round($record->score, 2),
                    round($record->avg_score, 2),
                    round($record->avg_seconds_used, 2),
                    round($record->rate, 2),
                ];

                ++$count;
            }
        }

        return new Table($headers, $data);
    }

    protected function schoolParticipationRateRankingTable()
    {
        $headers = ['排名', '學校名字', '參賽人數'];
        $data = [];
        $count = 0;

        if (array_key_exists('participate_count', $this->rankingData)) {
            foreach ($this->rankingData['participate_count'] as $record) {
                $data[$count] = [
                    $this->rankingStyle($count + 1),
                    $record['name'],
                    // $record['student'],
                    $record['participants'],
                    // round($record['rate'], 2),
                ];

                ++$count;
            }
        }

        return new Table($headers, $data);
    }

    protected function schoolAccumulateScoreRankingTable()
    {
        $headers = ['排名', '學校名字', '總累計分數', '總用時（秒）'];
        $data = [];
        $count = 0;

        if (array_key_exists('accumulate_score', $this->rankingData)) {
            foreach ($this->rankingData['accumulate_score'] as $record) {
                $data[$count] = [
                    $this->rankingStyle($count + 1),
                    $record['name'],
                    $record['score'] ?? 0,
                    $record['seconds_used'] ?? 0,
                ];

                ++$count;
            }
        }

        return new Table($headers, $data);
    }

    protected function personalRankingTable()
    {
        $headers = ['排名', '參賽編號', '姓名', '得分', '用時（秒）', '所屬學校'];
        $data = [];
        $count = 0;

        if (array_key_exists('personal', $this->rankingData)) {
            foreach ($this->rankingData['personal'] as $record) {
                $data[$count] = [
                    $this->rankingStyle($count + 1),
                    $record['participant_id'],
                    $record['participant_name'],
                    $record['score'],
                    $record['seconds_used'],
                    $record['school_name'],
                ];

                ++$count;
            }
        }

        return new Table($headers, $data);
    }

    protected function personalExtraRankingTable()
    {
        $headers = ['排名', '參賽編號', '姓名', '得分', '用時（秒）', '所屬學校'];
        $data = [];
        $count = 0;

        if (array_key_exists('personal_extra_ranking', $this->rankingData)) {
            foreach ($this->rankingData['personal_extra_ranking'] as $record) {
                $data[$count] = [
                    $this->rankingStyle($count + 1),
                    $record['participant_id'],
                    $record['participant_name'],
                    $record['score'],
                    $record['seconds_used'],
                    $record['school_name'],
                ];

                ++$count;
            }
        }

        return new Table($headers, $data);
    }

    protected function personalWeeklyRankingTable($title, $yearWeek, $rankings)
    {
        $headers = ['排名', '參賽編號', '姓名', '得分', '用時（秒）', '所屬學校'];
        $data = [];
        $count = 0;

        foreach ($rankings as $record) {
            $data[$count] = [
                $this->rankingStyle($count + 1),
                $record['participant_id'],
                $record['participant_name'],
                $record['score'],
                $record['seconds_used'],
                $record['school_name'],
            ];

            ++$count;
        }

        $exportLink = route('admin.export', [
            'season_id' => $this->seasonId,
            'yearWeek' => $yearWeek,
            'title' => $title,
        ]);

        return (new RankingTable($headers, $data))->setExportLink($exportLink);
    }

    public function schoolWinnerTable()
    {
        $headers = ['所屬學校', '排名', '姓名', '年級', '班別', '得分', '用時（秒）'];
        $data = [];
        $count = 0;

        if (array_key_exists('school_winner', $this->rankingData)) {
            foreach ($this->rankingData['school_winner'] as $name => $records) {
                foreach ($records as $record) {
                    $data[] = [
                        $name,
                        $this->schoolWinnerRankingStyle($count + 1),
                        $record['name'],
                        $record['grade'],
                        $record['class'],
                        $record['score'],
                        $record['seconds_used'],
                    ];

                    ++$count;
                }

                $count = 0;
            }
        }

        return new Table($headers, $data);
    }

    protected function rankingStyle($num)
    {
        if ($num <= 5) {
            return "<span class='badge bg-green'>".$num.'</span>';
        } else {
            return "<span class='badge'>".$num.'</span>';
        }
    }

    protected function schoolWinnerRankingStyle($num)
    {
        switch ($num) {
            case 1:
                $color = 'success';
                break;
            case 2:
                $color = 'warning';
                break;
            default:
                $color = 'danger';
                break;
        }

        return "<span class='label label-{$color}'>{$num}</span>";
    }
}
