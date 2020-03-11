<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\RankingManager;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Box;
use App\Admin\Models\Season;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $this->seasonId = $request->season ?? latestSeason()->id;

        $rankingManager = RankingManager::setSeasonId(intval($this->seasonId));

        $this->rankingData = $rankingManager->getAllRanking();
        $this->lastUpdatedAt = $rankingManager->getLastUpdatedAt();

        $content = Admin::content(function (Content $content) {
            $content->header('排行榜');
            $content->description('最後更新於'.$this->lastUpdatedAt);

            $content->row(function ($row) {
                $seasonId = $this->seasonId;
                $seasons = Season::whereIn('status', ['open', 'closed'])->get();

                $row->column(
                    12,
                    new Box('選擇賽季', view('admin.ranking.season_button_group', compact('seasons', 'seasonId')))
                );
            });

            $content->row(function ($row) {
                $row->column(
                    12,
                    '<b>中學排行榜</b>'
                );
            });

            //Dashboard summary
            $content->row(function ($row) {
                // $row->column(
                //     6,
                //     (
                //         new Box(
                //             '學校出線排行榜',
                //             $this->schoolRankingTable()->render()
                //         )
                //     )->collapsable()->solid()->style('success')
                // );

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
                            '最強知識王者',
                            $this->personalRankingTable()->render()
                        )
                    )->collapsable()->style('danger')
                );

                // $row->column(
                //     12,
                //     (
                //         new Box(
                //             '各校前3名',
                //             $this->schoolWinnerTable()->render()
                //         )
                //     )->collapsable()->style('danger')
                // );
            });

            $content->row(function ($row) {
                $row->column(
                    12,
                    '<b>大學排行榜</b>'
                );
            });

            //Dashboard summary
            $content->row(function ($row) {
                // $row->column(
                //     6,
                //     (
                //         new Box(
                //             '學校出線排行榜',
                //             $this->schoolRankingTable()->render()
                //         )
                //     )->collapsable()->solid()->style('success')
                // );

                $row->column(
                    6,
                    (
                        new Box(
                            '最傑出學校表現',
                            $this->schoolAccumulateScoreRankingTable('university')->render()
                        )
                    )->collapsable()->style('info')
                );

                $row->column(
                    6,
                    (
                        new Box(
                            '最具人氣學校',
                            $this->schoolParticipationRateRankingTable('university')->render()
                        )
                    )->collapsable()->style('warning')
                );

                $row->column(
                    6,
                    (
                        new Box(
                            '最強知識王者',
                            $this->personalRankingTable('university')->render()
                        )
                    )->collapsable()->style('danger')
                );

                // $row->column(
                //     12,
                //     (
                //         new Box(
                //             '各校前3名',
                //             $this->schoolWinnerTable()->render()
                //         )
                //     )->collapsable()->style('danger')
                // );
            });
        });

        unset($this->rankingData);

        return $content;
    }

    protected function schoolRankingTable($type = 'secondary')
    {
        $headers = ['排名', '學校名字', '成績', '前50平均得分', '前50平均用時（秒）', '參加比率%'];

        $data = [];
        $count = 0;

        if (isset($this->rankingData['school'][$type]) && count($this->rankingData['school'][$type])) {
            foreach ($this->rankingData['school'][$type] as $record) {
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

    protected function schoolParticipationRateRankingTable($type = 'secondary')
    {
        $headers = ['排名', '學校名字', '參賽人數'];
        $data = [];
        $count = 0;

        if (isset($this->rankingData['participate_count'][$type]) && count($this->rankingData['participate_count'][$type])) {
            foreach ($this->rankingData['participate_count'][$type] as $record) {
                $data[$count] = [
                    $this->rankingStyle($count + 1),
                    $record->name,
                    // $record->student,
                    $record->participants,
                    // round($record->rate, 2),
                ];

                ++$count;
            }
        }

        return new Table($headers, $data);
    }

    protected function schoolAccumulateScoreRankingTable($type = 'secondary')
    {
        $rankingData = $this->rankingData;
        $headers = ['排名', '學校名字', '總累計分數', '總用時（秒）'];
        $data = [];
        $count = 0;
        if (isset($rankingData['accumulate_score'][$type]) && count($rankingData['accumulate_score'][$type])) {
            foreach ($rankingData['accumulate_score'][$type] as $record) {
                $data[$count] = [
                    $this->rankingStyle($count + 1),
                    $record->name,
                    $record->score ?? 0,
                    $record->seconds_used ?? 0,
                ];

                ++$count;
            }
        }

        return new Table($headers, $data);
    }

    protected function personalRankingTable($type = 'secondary')
    {
        $headers = ['排名', '參賽編號', '姓名', '得分', '用時（秒）', '所屬學校'];
        $data = [];
        $count = 0;

        if (isset($this->rankingData['personal'][$type]) && count($this->rankingData['personal'][$type])) {
            foreach ($this->rankingData['personal'][$type] as $record) {
                $data[$count] = [
                    $this->rankingStyle($count + 1),
                    $record->participant_id,
                    $record->participant->name,
                    $record->score,
                    $record->seconds_used,
                    $record->participant->school->name,
                ];

                ++$count;
            }
        }

        return new Table($headers, $data);
    }

    public function schoolWinnerTable()
    {
        $headers = ['所屬學校', '排名', '姓名', '年級', '班別', '得分', '用時（秒）'];
        $data = [];
        $count = 0;

        if (isset($this->rankingData['school_winner']) && count($this->rankingData['school_winner'])) {
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
