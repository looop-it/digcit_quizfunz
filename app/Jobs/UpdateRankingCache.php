<?php

namespace App\Jobs;

use App\Facades\RankingManager;
use App\Jobs\DataMigration\PushRankingData;
use App\Models\BasicScore;
use App\Models\Participant;
use App\Models\PersonalExtraRanking;
use App\Models\School;
use App\Models\WeeklyBasicScore;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

/**
 * Update function for support school type : secondary, university, 20200302 yk.
 */
class UpdateRankingCache implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const RANK_LIMIT = 50;
    private const SCHOOL_RANK_TOTAL_SCORE = 250;
    private const SCHOOL_RANK_PARTICIPANT = 50;
    private const SCHOOL_RANK_SCORE_RATIO = 0.7;
    private const SCHOOL_RANK_PARTICIPATE_RATIO = 0.3;

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

        $this->updateWeeklyRanking();
        $this->updateSchoolParticipateRateRanking();
        $this->updateSchoolAccumulateScoreRanking();
        $this->updatePersonalRanking();
        // $this->updateSchoolWinnerRanking();
        // $this->updateSchoolRanking();
        $this->updatePersonalExtraRanking();

        // dispatch(new PushRankingData());
    }

    /**
     * 根據預設的星期時段，更新星期排行榜內容.
     */
    private function updateWeeklyRanking()
    {
        $personWeekly = [];

        $weeklyRankingRange = weekly_ranking_range();
        $seasonEndDate = Carbon::parse(latestSeason()->end_at);

        // Get current year & week to generate current or past week's rankings
        // Not future week ranking
        if ($seasonEndDate < now()) {
            $currentYear = $seasonEndDate->year;
            $currentWeek = $seasonEndDate->weekOfYear;
        } else {
            $currentYear = Carbon::now()->year;
            $currentWeek = Carbon::now()->weekOfYear;
        }

        if (count($weeklyRankingRange) > 0) {
            foreach ($weeklyRankingRange as $year => $weeks) {
                if ($year > $currentYear) {
                    continue;
                }

                foreach ($weeks as $week => $range) {
                    if ($week > $currentWeek && $year == $currentYear) {
                        continue;
                    }

                    $rankingData = [];

                    // // Get participants list who reach the top-10 times limit before this week
                    // $rejects = PersonalExtraRanking::select(['participant_id'])
                    //                                 ->where('added_year', '<', $year)
                    //                                 ->orWhere(function ($query) use ($year, $week) {
                    //                                     $query->where('added_week', '<', $week)->where('added_year', $year);
                    //                                 })
                    //                                 ->get()
                    //                                 ->pluck('participant_id');

                    $rankings = WeeklyBasicScore::with('participant.user')
                                            ->whereHas('participant.school', function ($query) {
                                                $query->where('type', 'secondary');
                                            })
                                            ->inSeason($this->seasonId)
                                            ->inYear($year)
                                            ->inWeek($week)
                                            ->where('rank', '>', 0)
                                            ->orderBy('rank', 'asc')
                                            // ->orderBy('score', 'desc')
                                            // ->orderBy('seconds_used', 'asc')
                                            // ->orderBy('started_at', 'asc')
                                            ->take(self::RANK_LIMIT)
                                            ->get();

                    if (count($rankings) > 0) {
                        foreach ($rankings as $ranking) {
                            $participant = $ranking->participant;

                            $rankingData[] = [
                                'participant_id' => $participant->id,
                                'uuid' => $participant->user->uuid,
                                'participant_name' => $participant->name,
                                'grade' => $participant->grade,
                                'class' => $participant->class,
                                'school_name' => $participant->school->name,
                                'score' => $ranking->score,
                                'seconds_used' => $ranking->seconds_used,
                                'started_at' => $ranking->started_at,
                            ];
                        }
                    }

                    $personWeekly["{$year}_{$week}"] = $rankingData;
                }
            }
        }

        $this->rankingManager->setCache('personal_weekly', $personWeekly);
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
                            // Get average seconds used of top n participants for sorting.
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

        $ranking = $schools->map(function ($school) {
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
        if ($school->student > 0) {
            $rate = $school->participants / $school->student * 100;

            if ($rate > 100) {
                return 100;
            }

            return $rate;
        }

        return 0;
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
        $schools = School::approved()
                        ->select('id', 'name', 'student')
                        ->withCount([
                            // Get realtime participant count
                            'basicScores as participants' => function ($query) {
                                $query->where('season_id', $this->seasonId);
                            },
                        ])
                        ->having('participants', '>', 0)
                        ->orderBy('participants', 'desc')
                        ->get();
        // temp modify remove sorting from rate    ->sortByDesc('participants')
        $schools = $schools->map(function ($school) {
            return array_add($school, 'rate', $this->getParticipateRate($school));
        })->take(self::RANK_LIMIT);

        $rankingData = [];

        foreach ($schools as $school) {
            $rankingData[] = [
                'name' => $school->name,
                'participants' => $school->participants,
                'students' => $school->student,
                'rate' => $school->rate,
            ];
        }

        $this->rankingManager->setCache('participate_count', $rankingData);
    }

    /**
     * 學校累計分數排行榜.
     */
    private function updateSchoolAccumulateScoreRanking()
    {
        // Get school list with basic scores: SUM(socre) and SUM(seconds_used)
        // rewrite withCount function
        $schools = School::approved()
                        ->select('id', 'name')
                        ->withCount([
                            'basicScores as score' => function ($query) {
                                $query->select(DB::raw('SUM(score)'))
                                      ->where('season_id', $this->seasonId);
                            },
                            'basicScores as seconds_used' => function ($query) {
                                $query->select(DB::raw('SUM(seconds_used)'))
                                      ->where('season_id', $this->seasonId);
                            },
                        ])
                        ->having('score', '>', 0)
                        ->orderBy('score', 'desc')
                        ->orderBy('seconds_used', 'asc')
                        ->get();

        $rankingData = [];

        foreach ($schools as $index => $school) {
            $rankingData[] = [
                'name' => $school->name,
                'score' => $school->score,
                'seconds_used' => $school->seconds_used,
            ];
        }

        $this->rankingManager->setCache('accumulate_score', $rankingData);
    }

    /**
     * 灣區學霸排行榜.
     * Get top n participants ranking by season id order by score desc, seconds_used asc.
     */
    private function updatePersonalRanking()
    {
        $students = BasicScore::whereHas('participant.school', function ($query) {
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

        $rankingData = [];

        foreach ($students as $student) {
            $rankingData[] = [
                'participant_id' => $student->participant->id,
                'participant_name' => $student->participant->name,
                'score' => $student->score,
                'seconds_used' => $student->seconds_used,
                'school_name' => $student->participant->school->name,
            ];
        }

        $this->rankingManager->setCache('personal', $rankingData);
    }

    private function updateSchoolWinnerRanking()
    {
        $data = [];
        $count = 0;

        $ranking = BasicScore::with([
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
                if ($count >= 3) {
                    break;
                }

                $data[$name][] = [
                    'name' => $record->participant->name,
                    'grade' => $record->participant->grade,
                    'class' => $record->participant->class,
                    'score' => $record->score,
                    'seconds_used' => $record->seconds_used,
                ];

                ++$count;
            }

            $count = 0;
        }

        $this->rankingManager->setCache('school_winner', $data);
    }

    /**
     * 封神榜排行榜，連續三次獲得周排行榜前十的將進入封神榜，不再參與之後的周排名.
     * Get participants who win the TOP-3 over 3 times.
     */
    private function updatePersonalExtraRanking()
    {
        $students = PersonalExtraRanking::with([
                                'participant.school' => function ($query) {
                                    $query->select('id', 'name');
                                },
                            ])
                            ->inSeason($this->seasonId)
                            ->orderBy('sum_scores', 'desc')
                            ->orderBy('sum_seconds', 'asc')
                            ->take(self::RANK_LIMIT)
                            ->get();

        $rankingData = [];

        foreach ($students as $student) {
            $student->sum_scores = $student->participant->papers()->inSeason(latestSeason()->id)->finished()->sum('score');
            $student->sum_seconds = $student->participant->papers()->inSeason(latestSeason()->id)->finished()->sum('seconds_used');
            $student->save();

            $rankingData[] = [
                'participant_id' => $student->participant->id,
                'participant_name' => $student->participant->name,
                // get the realtime sum score and seconds
                'score' => $student->sum_scores,
                'seconds_used' => $student->sum_seconds,
                'school_name' => $student->participant->school->name,
            ];
        }

        $this->rankingManager->setCache('personal_extra_ranking', $rankingData);
    }
}
