<?php

namespace App\Console;

use App\Console\Commands\PaperCleanTimeout;
use App\Console\Commands\PaperGenerate;
use App\Console\Commands\QuestionCalcCorrectRate;
use App\Console\Commands\QuestionCalcHitRate;
use App\Console\Commands\SchoolSendDailyReport;
use App\Console\Commands\SchoolUpdateStatistics;
use App\Jobs\Paper\GeneratePaperForCurrentSeason;
use App\Jobs\PushWeeklyRankingData;
use App\Jobs\SendParticipationReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        SchoolUpdateStatistics::class,
        SchoolSendDailyReport::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        if (season()) {
            $schedule->command('paper:clean-timeout')->everyMinute();
            // $schedule->command('paper:clean-reviewing')->everyMinute();

            $schedule->command('school:update-statistics')->hourlyAt(1);
            $schedule->command('participant:update-weekly-basic-score 1')->hourlyAt(5);
            $schedule->command('ranking:update')->hourlyAt(11);

            $schedule->command('question:calc-correct-rate')->daily();
            $schedule->command('question:calc-hit-rate')->daily();
            $schedule->command('consolidate:user-stats')->daily();

            $schedule->job(new GeneratePaperForCurrentSeason())->hourly();
            // $schedule->job(new PushWeeklyRankingData())->hourlyAt(15);

            // $schedule->job(new SendParticipationReminder)->weekly()->mondays()->at('00:30');
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
