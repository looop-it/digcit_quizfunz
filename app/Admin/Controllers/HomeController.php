<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\InfoBox;
use App\Admin\Models\User;
use App\Admin\Models\School;
use App\Admin\Models\Participant;
use App\Admin\Models\Question;
use App\Admin\Models\Paper;
use App\Admin\Models\Company;
use Encore\Admin\Widgets\Box;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Get company info for dashboard setting.
     */
    public function __construct()
    {
        // Cache summary count data
        $this->schoolsCount = Cache::remember(
            'dashboard-summary-schoolsCount-cache',
            5,
            function () {
                return  School::approved()->count().'/'.School::count();
            }
        );

        $this->registrationCount = Cache::remember(
            'dashboard-summary-registrationCount-cache',
            5,
            function () {
                $participant_count = Participant::count();
                $user_count = User::competition()->count();

                return $participant_count.'/'.$user_count;
            }
        );

        $this->questionsCount = Cache::remember(
            'dashboard-summary-questionsCount-cache',
            5,
            function () {
                return  Question::enabled()->count().'/'.Question::count();
            }
        );

        $this->papersCount = Cache::remember(
            'dashboard-summary-papersCount-cache',
            5,
            function () {
                return  Paper::where('status', 'finished')->count().'/'.Paper::count();
            }
        );
    }

    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('控制面板');
            $content->description('概覽');

            //Dashboard summary
            $content->row(function ($row) {
                $row->column(3, new InfoBox('學生(參賽/登記)', 'users', 'aqua', '/admin/students', $this->registrationCount));
                $row->column(3, new InfoBox('學校登記(批准/全部)', 'building-o', 'green', '/admin/schools', $this->schoolsCount));
                $row->column(3, new InfoBox('賽題(啟用/全部)', 'question-circle', 'yellow', '/admin/questions', $this->questionsCount));
                $row->column(3, new InfoBox('答題卷(已答/全部)', 'newspaper-o', 'blue', '/admin/papers', $this->papersCount));
            });

            // Dashboard charts
            $content->row(function ($row) {
                $row->column(12, new Box('当日挑戰情況', $this->challengeCountChart()->render()));
                $row->column(6, new Box('比賽情況統計', $this->papersDaliyCountChart()->render()));
                $row->column(6, new Box('答题卷狀態統計', $this->papersStatusCountChart()->render()));
                $row->column(6, new Box('學校參加人數統計', $this->schoolsCountChart()->render()));
                // $row->column(6, new Box('學校參加率統計', $this->schoolsCountRateChart()->render()));

                // Manually dispatch a DOMContentLoaded event to load chart under pajax request
                Admin::script($this->script());
            });
        });
    }

    // Ref color code
    // red: 'rgb(255, 99, 132)',
    // orange: 'rgb(255, 159, 64)',
    // yellow: 'rgb(255, 205, 86)',
    // green: 'rgb(75, 192, 192)',
    // blue: 'rgb(54, 162, 235)',
    // purple: 'rgb(153, 102, 255)',
    // grey: 'rgb(201, 203, 207)'
    protected function challengeCountChart()
    {
        // Get daliy count by grouping date and participant_id
        $challengeStats = Cache::remember('dashboard-chart-challengeCount-cache', 5, function () {
            $data = [];

            $today = Carbon::today();

            $startTime = $today->format('Y-m-d 00:00:00');
            $endTime = $today->format('Y-m-d 23:59:59');

            $papers = Paper::finished()
                            ->whereBetween('started_at', [
                                $startTime,
                                $endTime,
                            ])
                            ->get();

            // Parse paper into series
            $timestamp = Carbon::parse($startTime);

            do {
                $start = $timestamp->format('H:i');

                $paperCount = $papers->where('started_at', '>=', $timestamp->format('Y-m-d H:i:s'))
                        ->where('started_at', '<=', $timestamp->addMinutes(5)->format('Y-m-d H:i:s'))
                        ->count();

                $data['label'][] = $start;
                $data['dataset'][] = $paperCount;
            } while ($timestamp->lessThan(Carbon::parse($endTime)));

            return $data;
        });

        // Build paper count line chart
        $chartjs = app()->chartjs
                ->name('challengeCount')
                ->type('line')
                ->size(['width' => 1600, 'height' => 400])
                ->labels($challengeStats['label'])
                ->datasets([
                    [
                        'label' => '挑戰次數',
                        'backgroundColor' => 'rgba(38, 185, 154, 0.2)',
                        'borderColor' => 'rgba(75, 192, 192, 0.8)',
                        'pointBorderColor' => 'rgba(38, 185, 154, 0.7)',
                        'pointBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                        'pointHoverBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                        'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                        'data' => $challengeStats['dataset'],
                    ],
                ])
                ->optionsRaw(
                    "{
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }"
                );

        return $chartjs;
    }

    protected function papersDaliyCountChart()
    {
        // Get daliy count by grouping date and participant_id
        $papersDaliyCount = Cache::remember(
            'dashboard-chart-papersDaliyCount-cache',
            5,
            function () {
                return Paper::finished()->select(DB::raw('count(id) as count , DATE_FORMAT(started_at,"%Y-%m-%d") AS date'))->groupBy(DB::raw('DATE_FORMAT(started_at,"%Y-%m-%d")'), 'participant_id')->get();
            }
        )->groupBy('date');
        // Get date label by keys
        $papersDaliyCountLabel = $papersDaliyCount->keys();

        $papersDaliyCountByPaper = $papersDaliyCount->map(
            function ($item, $key) {
                // Sum for papers
                return $item->sum('count');
            }
        )->values();

        $papersDaliyCountByParticipant = $papersDaliyCount->map(
            function ($item, $key) {
                // Count for Participants
                return $item->count('count');
            }
        )->values();

        // Build paper count line chart
        $chartjs = app()->chartjs
                ->name('papersDaliyCount')
                ->type('line')
                ->size(['width' => 400, 'height' => 200])
                ->labels($papersDaliyCountLabel->toArray())
                ->datasets([
                    [
                        'label' => '完賽問卷數',
                        'backgroundColor' => 'rgba(38, 185, 154, 0.2)',
                        'borderColor' => 'rgba(75, 192, 192, 0.8)',
                        'pointBorderColor' => 'rgba(38, 185, 154, 0.7)',
                        'pointBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                        'pointHoverBackgroundColor' => 'rgba(38, 185, 154, 0.7)',
                        'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                        'data' => $papersDaliyCountByPaper->toArray(),
                    ],
                    [
                        'label' => '參賽人數',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderColor' => 'rgba(255, 99, 132, 0.8)',
                        'pointBorderColor' => 'rgba(255, 99, 132, 1)',
                        'pointBackgroundColor' => 'rgba(255, 99, 132, 0.7)',
                        'pointHoverBackgroundColor' => 'rgba(255, 99, 132, 1)',
                        'pointHoverBorderColor' => 'rgba(220,220,220,1)',
                        'data' => $papersDaliyCountByParticipant->toArray(),
                    ],
                ])
                ->optionsRaw(
                    "{
                    responsive: true,
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }"
                );

        return $chartjs;
    }

    protected function papersStatusCountChart()
    {
        // Get paper status count data
        $papersStatusCount = Cache::remember(
            'dashboard-chart-papersStatusCount-cache',
            5,
            function () {
                return Paper::select(DB::raw('count(*) as count , status'))->groupBy('status')->get();
            }
        );
        // Build paper status pie chart
        $chartjs = app()->chartjs
            ->name('papersStatusCount')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels($papersStatusCount->pluck('status')->toArray())
            ->datasets(
                [
                    [
                        'label' => '問卷狀態統計',
                        'backgroundColor' => ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 205, 86, 0.8)'],
                        'data' => $papersStatusCount->pluck('count')->toArray(),
                    ],
                ]
            )
            ->options([]);

        return $chartjs;
    }

    protected function schoolsCountChart()
    {
        // Get School and participant count
        $schoolsCount = Cache::remember(
            'dashboard-chart-schoolsCount-cache',
            5,
            function () {
                return School::approved()->orderBy('actual_participant', 'desc')->take(10)->get();
            }
        );
        // Build school participant count bar chart
        $chartjs = app()->chartjs
            ->name('schoolsCount')
            ->type('horizontalBar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($schoolsCount->pluck('name')->toArray())
            ->datasets(
                [
                    [
                        'label' => '實際參賽人數',
                        'backgroundColor' => 'rgba(75, 192, 192, 1)',
                        'data' => $schoolsCount->pluck('actual_participant')->toArray(),
                    ],
                    // [
                    //     'label' => '預期參賽人數',
                    //     'backgroundColor' => 'rgba(54, 162, 235, 0.3)',
                    //     'data' => $schoolsCount->pluck('expected_participant')->toArray(),
                    // ],
                ]
            )->optionsRaw(
                "{
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        yAxes: [{
                            stacked: true
                        }]
                    },
                }"
            );

        return $chartjs;
    }

    protected function schoolsCountRateChart()
    {
        // Get School and participant count
        $schoolsCountRate = Cache::remember(
            'dashboard-chart-schoolsCountRate-cache',
            5,
            function () {
                return School::approved()->select(DB::raw('round((actual_participant/student),4)*100 as rate, name'))->orderBy('rate', 'desc')->take(10)->get();
            }
        );
        $chartjs = app()->chartjs
            ->name('schoolsCountRate')
            ->type('horizontalBar')
            ->size(['width' => 400, 'height' => 200])
            ->labels($schoolsCountRate->pluck('name')->toArray())
            ->datasets(
                [
                    [
                        'label' => '參賽率(%)',
                        'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                        'data' => $schoolsCountRate->pluck('rate')->toArray(),
                    ],
                ]
            )->optionsRaw(
                '{
                    responsive: true,
                    scales: {
                        xAxes: [{
                            ticks: {
                                suggestedmin: 10,
                                suggestedMax:30,
                            },
                            
                        }]
                    }
                }'
            );

        return $chartjs;
    }

    /**
     * Define a js script to manually dispatch DOMContentLoaded event.
     *
     * @return string [description]
     */
    protected function script()
    {
        return <<<EOT

var DOMContentLoaded_event = document.createEvent("Event")
DOMContentLoaded_event.initEvent("DOMContentLoaded", true, true)
window.document.dispatchEvent(DOMContentLoaded_event)
EOT;
    }
}
