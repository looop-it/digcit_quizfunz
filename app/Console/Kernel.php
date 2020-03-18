<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PaperGenerate;
use App\Console\Commands\PaperCleanTimeout;
use App\Console\Commands\QuestionCalcHitRate;
use App\Console\Commands\QuestionCalcCorrectRate;
use App\Console\Commands\SchoolUpdateParticipantCount;
use App\Console\Commands\SchoolSendDailyReport;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        PaperGenerate::class,
        PaperCleanTimeout::class,
        QuestionCalcCorrectRate::class,
        QuestionCalcHitRate::class,
        SchoolUpdateParticipantCount::class,
        SchoolSendDailyReport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        if (season()) {
            $schedule->command('paper:clean-timeout')->everyMinute();
            // $schedule->command('paper:clean-reviewing')->everyMinute();

            $schedule->command('school:update-participant-count')->hourlyAt(1);
            $schedule->command('participant:update-weekly-basic-score 1')->hourlyAt(5);
            $schedule->command('ranking:update')->hourlyAt(11);

            $schedule->command('question:calc-correct-rate')->daily();
            $schedule->command('question:calc-hit-rate')->daily();
            $schedule->command('consolidate:user-stats')->daily();
        }

        if (config('report.send_daily_report')) {
            $schedule->command('school:daily-report')->dailyAt('08:00');
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
