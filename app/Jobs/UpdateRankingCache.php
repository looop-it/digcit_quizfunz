<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Facades\RankingManager;
use App\Models\School;
use App\Models\BasicScore;
use App\Models\WeeklyBasicScore;
use App\Models\Participant;

/**
 * Update function for support school type : secondary, university, 20200302 yk.
 */
class UpdateRankingCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const RANK_LIMIT = 50;
    private const SCHOOL_RANK_TOTAL_SCORE = 250;
    private const SCHOOL_RANK_PARTICIPANT = 50;
    private const SCHOOL_RANK_SCORE_RATIO = 0.8;
    private const SCHOOL_RANK_PARTICIPATE_RATIO = 0.2;

    private $seasonId;
    private $rankingManager;

    /**
     * Create a new job instance.
     */
    public function __construct(int $seasonId)
    {
        $this->seasonId = $seasonId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->rankingManager = RankingManager::setSeasonId($this->seasonId);

        $this->updateSchoolRanking();
        $this->updateSchoolParticipateRateRanking();
        $this->updateSchoolAccumulateScoreRanking();
        $this->updatePersonalRanking();
        $this->updateSchoolWinnerRanking();
        $this->updateWeeklyRanking();
    }

    /**
     * 根據預設的星期時段，更新星期排行榜內容.
     */
    private function updateWeeklyRanking()
    {
        $weekly_ranking_range = config('competition.weekly_ranking_range');
        
        $currentYear = Carbon::now()->year;
        $currentWeek = Carbon::now()->weekOfYear;

        if (count($weekly_ranking_range) > 0) {
            foreach ($weekly_ranking_range as $year => $weeks) {
                if ($year <= $currentYear) {
                    foreach ($weeks as $week => $range) {
                        if ($week <= $currentWeek) {
                            $personal_weekly['secondary']["{$year}_{$week}"] = WeeklyBasicScore::select('id', 'participant_id', 'score', 'seconds_used', 'started_at')
                                ->whereHas('participant.school', function ($query) {
                                    $query->where('type', 'secondary');
                                })
                                ->with([
                                    'participant.school' => function ($query) {
                                        $query->with('teachers')->select('id', 'name');
                                    },
                                ])
                                ->inSeason($this->seasonId)
                                ->inWeek($week)
                                ->orderBy('score', 'desc')
                                ->orderBy('seconds_used', 'asc')
                                ->orderBy('started_at', 'asc')
                                ->take(self::RANK_LIMIT)
                                ->get();
                        }
                    }
                }
            }
        }

        $this->rankingManager->setCache('personal_weekly', $personal_weekly);
    }

    /**
     * 學校出線排行榜.
     */
    private function updateSchoolRanking()
    {
        $schools = School::approved()
                        ->select('id', 'name', 'student')
                        ->withCount([
                            // Get realtime participant count
                            'basicScores as participants' => function ($query) {
                                $query->where('season_id', $this->seasonId);
                            },
                            // Get average score of top n participants
                            // 'basicScores as avg_score' => function ($query) {
                            //     $query->where('season_id', $this->seasonId)
                            //         ->orderBy('score', 'desc')
                            //         ->orderBy('seconds_used', 'asc')
                            //         ->take(self::SCHOOL_RANK_PARTICIPANT);
                            // },
                            // // Get average seconds used of top n participants for sorting.
                            // 'basicScores as avg_seconds_used' => function ($query) {
                            //     $query->select(DB::raw("AVG(seconds_used)"))
                            //         ->where('season_id', $this->seasonId)
                            //         ->orderBy('score', 'desc')
                            //         ->orderBy('seconds_used', 'asc')
                            //         ->take(self::SCHOOL_RANK_PARTICIPANT);
                            // }
                        ])
                        ->having('participants', '>=', self::SCHOOL_RANK_PARTICIPANT)
                        ->get();

        $ranking = $schools->map(function ($school, $key) {
            $school->load([
                'basicScores' => function ($query) {
                    $query->where('season_id', $this->seasonId)
                        ->orderBy('score', 'desc')
                        ->orderBy('seconds_used', 'asc')
                        ->orderBy('started_at', 'asc')
                        ->take(self::SCHOOL_RANK_PARTICIPANT);
                },
            ]);

            $avgScore = $school->basicScores->avg('score');
            $avgSecondsUsed = $school->basicScores->avg('seconds_used');

            $school->avg_score = $avgScore;
            $school->avg_seconds_used = $avgSecondsUsed;

            array_add($school, 'avg_score', $avgScore);
            array_add($school, 'avg_seconds_used', $avgSecondsUsed);
            array_add($school, 'rate', $this->getParticipateRate($school));
            array_add($school, 'score', $this->getSchoolRankingScore($school));

            return $school;
        })
        ->sortBy('avg_seconds_used')
        ->sortBy('avg_score')
        ->sortByDesc('score')
        ->take(self::RANK_LIMIT);

        $this->rankingManager->setCache('school', $ranking);
    }

    /**
     * Get school participate rate.
     *
     * @param [type] $school
     */
    private function getParticipateRate($school)
    {
        // Disable rate for history quiz
        // $rate = $school->participants / $school->student * 100;

        // if ($rate > 100) {
        //     return 100;
        // }

        $rate = 0;

        return $rate;
    }

    /**
     * Get school ranking score.
     *
     * @param [type] $school
     */
    private function getSchoolRankingScore($school)
    {
        return ($school->avg_score / self::SCHOOL_RANK_TOTAL_SCORE * 100 * self::SCHOOL_RANK_SCORE_RATIO) + ($this->getParticipateRate($school) * self::SCHOOL_RANK_PARTICIPATE_RATIO);
    }

    /**
     * 學校參加人數排行榜.
     */
    public function updateSchoolParticipateRateRanking()
    {
        // $schools = School::approved()
        //                 ->select('id', 'name', 'student')
        //                 ->withCount([
        //                     // Get realtime participant count
        //                     'basicScores as participants' => function ($query) {
        //                         $query->where('season_id', $this->seasonId);
        //                     },
        //                 ])
        //                 ->orderBy('participants', 'desc')
        //                 ->get();

        // $ranking = $schools->map(function ($school, $key) {
        //     return array_add($school, 'rate', $this->getParticipateRate($school));
        // })->sortByDesc('rate')->take(self::RANK_LIMIT);

        // Change rate to counts for history quiz
        $participate_count['secondary'] = School::approved()
                        ->ofType('secondary')
                        ->select('id', 'name')
                        ->withCount([
                            // Get realtime participant count
                            'basicScores as participants' => function ($query) {
                                $query->where('season_id', $this->seasonId);
                            },
                        ])
                        ->orderBy('participants', 'desc')
                        ->take(self::RANK_LIMIT)
                        ->get();

        // $participate_count['university'] = School::approved()
        //                 ->ofType('university')
        //                 ->select('id', 'name')
        //                 ->withCount([
        //                     // Get realtime participant count
        //                     'basicScores as participants' => function ($query) {
        //                         $query->where('season_id', $this->seasonId);
        //                     },
        //                 ])
        //                 ->orderBy('participants', 'desc')
        //                 ->take(self::RANK_LIMIT)
        //                 ->get();

        $this->rankingManager->setCache('participate_count', $participate_count);
    }

    /**
     * 學校累計分數排行榜.
     */
    private function updateSchoolAccumulateScoreRanking()
    {
        // Get school list with basic scores: SUM(socre) and SUM(seconds_used)
        // rewrite withCount function
        $accumulate_score['secondary'] = School::approved()
                        ->ofType('secondary')
                        ->select('id', 'name')->withCount([
                            'basicScores as score' => function ($query) {
                                $query->select(DB::raw('SUM(score)'))
                                      ->where('season_id', $this->seasonId);
                            },
                            'basicScores as seconds_used' => function ($query) {
                                $query->select(DB::raw('SUM(seconds_used)'))
                                      ->where('season_id', $this->seasonId);
                            },
                        ])
                        ->orderBy('score', 'desc')
                        ->orderBy('seconds_used', 'asc')
                        ->get();

        // $accumulate_score['university'] = School::approved()
        //                 ->ofType('university')
        //                 ->select('id', 'name')->withCount([
        //                     'basicScores as score' => function ($query) {
        //                         $query->select(DB::raw('SUM(score)'))
        //                               ->where('season_id', $this->seasonId);
        //                     },
        //                     'basicScores as seconds_used' => function ($query) {
        //                         $query->select(DB::raw('SUM(seconds_used)'))
        //                               ->where('season_id', $this->seasonId);
        //                     },
        //                 ])
        //                 ->orderBy('score', 'desc')
        //                 ->orderBy('seconds_used', 'asc')
        //                 ->get();

        $this->rankingManager->setCache('accumulate_score', $accumulate_score);
    }

    /**
     * 灣區學霸排行榜.
     * Get top n participants ranking by season id order by score desc, seconds_used asc.
     */
    private function updatePersonalRanking()
    {
        $personal['secondary'] = BasicScore::select('id', 'participant_id', 'score', 'seconds_used')
                            ->whereHas('participant.school', function ($query) {
                                $query->where('type', 'secondary');
                            })
                            ->with([
                                'participant.school' => function ($query) {
                                    $query->select('id', 'name');
                                },
                            ])
                            ->inSeason($this->seasonId)
                            ->orderBy('score', 'desc')
                            ->orderBy('seconds_used', 'asc')
                            ->orderBy('started_at', 'asc')
                            ->take(self::RANK_LIMIT)
                            ->get();

        // $personal['university'] = BasicScore::select('id', 'participant_id', 'score', 'seconds_used')
        //                     ->whereHas('participant.school', function ($query) {
        //                         $query->where('type', 'university');
        //                     })
        //                     ->with([
        //                         'participant.school' => function ($query) {
        //                             $query->select('id', 'name');
        //                         },
        //                     ])
        //                     ->inSeason($this->seasonId)
        //                     ->orderBy('score', 'desc')
        //                     ->orderBy('seconds_used', 'asc')
        //                     ->orderBy('started_at', 'asc')
        //                     ->take(self::RANK_LIMIT)
        //                     ->get();

        $this->rankingManager->setCache('personal', $personal);
    }

    private function updateSchoolWinnerRanking()
    {
        $data = [];
        $count = 0;

        $ranking = BasicScore::select('id', 'participant_id', 'score', 'seconds_used')
                            ->with([
                                'participant.school' => function ($query) {
                                    $query->select('id', 'name');
                                },
                            ])
                            ->inSeason($this->seasonId)
                            ->orderBy('score', 'desc')
                            ->orderBy('seconds_used', 'asc')
                            ->get();

        $rankingSorted = $ranking->map(function ($record) {
            $school = $record->participant->school;

            array_add($record, 'school_name', $school->name);

            return $record;
        })->groupBy('school_name');

        foreach ($rankingSorted as $name => $records) {
            foreach ($records as $record) {
                if ($count < 3) {
                    $data[$name][] = [
                        'name' => $record->participant->name,
                        'grade' => $record->participant->grade,
                        'class' => $record->participant->class,
                        'score' => $record->score,
                        'seconds_used' => $record->seconds_used,
                    ];

                    ++$count;
                } else {
                    break;
                }
            }

            $count = 0;
        }

        $this->rankingManager->setCache('school_winner', $data);
    }
}
