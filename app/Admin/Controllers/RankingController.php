<?php

namespace App\Admin\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Facades\RankingManager;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Widgets\Box;
use App\Admin\Models\Season;
use App\Admin\Widgets\RankingTable;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $this->seasonId = $request->season ?? latestSeason()->id;

        $rankingManager = RankingManager::setSeasonId(intval($this->seasonId));

        $this->rankingData = $rankingManager->getAllRanking();
        $this->lastUpdatedAt = $rankingManager->getLastUpdatedAt();

        $url = $request->fullUrlWithQuery(['type' => '_type_']);
        $type = $request->get('type', 'secondary');

        $content = Admin::content(function (Content $content) use ($url, $type) {
            $content->header('排行榜');
            $content->description('最後更新於'.$this->lastUpdatedAt);

            $content->row(function ($row) use ($url, $type) {
                $seasonId = $this->seasonId;
                $seasons = Season::whereIn('status', ['open', 'closed'])->get();
                $types = [
                    'secondary_weekly' => '每周排行榜',
                    'secondary' => '總排行榜',
                    // 'university' => '大學賽總排行榜',
                    // 'university_weekly' => '大學賽周排行榜',
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
                case 'secondary':
                    //Dashboard summary
                    $content->row(function ($row) {
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

                // case 'university':
                //     // 大學排行榜
                //     $content->row(function ($row) {
                //         $row->column(
                //             6,
                //             (
                //                 new Box(
                //                     '最傑出學校表現',
                //                     $this->schoolAccumulateScoreRankingTable('university')->render()
                //                 )
                //             )->collapsable()->style('info')
                //         );

                //         $row->column(
                //             6,
                //             (
                //                 new Box(
                //                     '最具人氣學校',
                //                     $this->schoolParticipationRateRankingTable('university')->render()
                //                 )
                //             )->collapsable()->style('warning')
                //         );

                //         $row->column(
                //             6,
                //             (
                //                 new Box(
                //                     '最強知識王者',
                //                     $this->personalRankingTable('university')->render()
                //                 )
                //             )->collapsable()->style('danger')
                //         );

                //         // $row->column(
                //         //     12,
                //         //     (
                //         //         new Box(
                //         //             '各校前3名',
                //         //             $this->schoolWinnerTable()->render()
                //         //         )
                //         //     )->collapsable()->style('danger')
                //         // );
                //     });
                //     break;

                case 'secondary_weekly':
                    $weeklyRankingRange = config('competition.weekly_ranking_range');

                    if ($weeklyRankingRange == null) {
                        $content->row(function ($row) {
                            $row->column(
                                6,
                                (
                                    new Box('錯誤', '未配置周排行榜日期範圍')
                                )
                            );
                        });
                    } else {
                        $content->row(function ($row) use ($weeklyRankingRange) {
                            $currentYear = Carbon::now()->year;
                            $currentWeek = Carbon::now()->weekOfYear;

                            foreach ($weeklyRankingRange as $year => $weeks) {
                                if ($year <= $currentYear) {
                                    foreach (array_reverse($weeks, true) as $week => $range) {
                                        if ($week <= $currentWeek) {
                                            $weekInIndex = array_search($week, $this->flattenWeeklyRankingRange()) + 1;

                                            $row->column(
                                                6,
                                                (
                                                    new Box(
                                                        "每周最強知識王(第{$weekInIndex}周) <{$range['start_date']}至{$range['end_date']}>",
                                                        $this->personalWeeklyRankingTable($year, $week, 'secondary')->render()
                                                    )
                                                )->collapsable()->style('danger')
                                            );
                                        }
                                    }
                                }
                            }
                        });
                    }

                    break;

                // case 'university_weekly':
                //     $weekly_ranking_range = config('competition.weekly_ranking_range');
                //     $current_week_of_year = Carbon::now()->weekOfYear;
                //     if ($weekly_ranking_range == null) {
                //         $content->row(function ($row) {
                //             $row->column(
                //                 6,
                //                 (
                //                     new Box(
                //                         '錯誤', '未配置周排行榜日期範圍'
                //                     )
                //                 )
                //             );
                //         });
                //     } else {
                //         $content->row(function ($row) use ($weekly_ranking_range, $current_week_of_year) {
                //             foreach ($weekly_ranking_range as $week_of_year => $date_range) {
                //                 if ($current_week_of_year >= $week_of_year) {
                //                     $row->column(
                //                         6,
                //                         (
                //                             new Box(
                //                                 '第 '.$week_of_year.' 周:'.$date_range['start_date'].' / '.$date_range['end_date'],
                //                                 $this->personalWeeklyRankingTable($week_of_year, 'university')->render()
                //                             )
                //                         )->collapsable()->style('danger')
                //                     );
                //                 }
                //             }
                //         });
                //     }

                //     break;
            }
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

    protected function personalWeeklyRankingTable($year, $week, $type = 'secondary')
    {
        $headers = ['排名', '參賽編號', '姓名', '得分', '用時（秒）', '所屬學校'];
        $data = [];
        $count = 0;
        $cacheKey = "{$year}_{$week}";

        if (isset($this->rankingData['personal_weekly'][$type][$cacheKey]) && count($this->rankingData['personal_weekly'][$type][$cacheKey])) {
            foreach ($this->rankingData['personal_weekly'][$type][$cacheKey] as $record) {
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

        $exportLink = route('admin.export', [
            'season_id' => $this->seasonId,
            'school_type' => $type,
            'year' => $year,
            'week' => $week
        ]);

        return (new RankingTable($headers, $data))->setExportLink($exportLink);
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

    private function flattenWeeklyRankingRange()
    {
        $range = config('competition.weekly_ranking_range');

        $flattenedRange = [];

        foreach ($range as $year => $weeks) {
            foreach ($weeks as $week => $dateRange) {
                $flattenedRange[] = $week;
            }
        }

        return $flattenedRange;
    }
}
