<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// class getWeeklyRankingRange implements ShouldQueue
class getWeeklyRankingRange
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $range = [];

        $startDate = '2020-10-19';
        $endDate = '2021-03-31';

        $date = $startDate;

        while (Carbon::parse($date)->lessThanOrEqualTo(Carbon::parse($endDate))) {
            $cDate = Carbon::parse($date);

            $range[$cDate->weekOfYear] = [
                'start_date' => $cDate->startOfWeek()->format('Y-m-d'),
                'end_date' => $cDate->endOfWeek()->format('Y-m-d'),
            ];

            $date = $cDate->addWeek()->format('Y-m-d');
        }

        return $range;
    }
}
