<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class CheckCompetitionTime
{
    private const MINUTES_BEFORE_CLOSE = 15;

    private $season;
    private $datetime;
    
    public function __construct()
    {
        $this->season = season();
        $this->datetime = now();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->inEnableDays() || !$this->inTimeRange()) {
            $message[] = '非比賽時間！請於比賽時間內挑戰。<br />';

            $message[] = $this->season->name;

            $message[] = sprintf(
                "比賽日期：%s 至 %s",
                \Carbon\Carbon::parse($this->season->start_at)->format('Y年m月d日'),
                \Carbon\Carbon::parse($this->season->end_at)->format('Y年m月d日')
            );

            $message[] = sprintf(
                "比賽時間：%s (%s - %s)",
                $this->getEnableDaysInName(),
                $this->season->day_start_time,
                $this->season->day_end_time
            );
        } else {
            if ($this->isClosed()) {
                $message = sprintf("抱歉，比賽時間結束前%d分鐘不可挑戰！", self::MINUTES_BEFORE_CLOSE);
            }
        }

        if (isset($message)) {
            return redirect()->route('competition.error')->with('message', $message);
        }

        return $next($request);
    }

    /**
     * Check if datetime in enabled days.
     *
     * @return boolean
     */
    private function inEnableDays() : bool
    {
        $day = $this->datetime->dayOfWeekIso;

        if (in_array($day, $this->season->enable_days)) {
            return true;
        }

        return false;
    }

    /**
     * Check if datetime in season's open time range.
     *
     * @return boolean
     */
    private function inTimeRange() : bool
    {
        if ($this->datetime->greaterThan($this->getStartTime()) && $this->datetime->lessThan($this->getEndTime())) {
            return true;
        }

        return false;
    }

    /**
     * Check if datime is with n minutes before day open time is closed.
     *
     * @return boolean
     */
    private function isClosed() : bool
    {
        if ($this->datetime->diffInMinutes($this->getEndTime()) <= self::MINUTES_BEFORE_CLOSE) {
            return true;
        }

        return false;
    }

    private function getStartTime()
    {
        return $this->datetime->format(sprintf("Y-m-d %s", $this->season->day_start_time));
    }

    private function getEndTime()
    {
        return $this->datetime->format(sprintf("Y-m-d %s", $this->season->day_end_time));
    }

    private function getEnableDaysInName()
    {
        $dayNames = [
            1 => '星期一',
            2 => '星期二',
            3 => '星期三',
            4 => '星期四',
            5 => '星期五',
            6 => '星期六',
            7 => '星期日'
        ];

        $enableDayInName = [];

        foreach ($this->season->enable_days as $day) {
            $enableDayInName[] = $dayNames[$day];
        }

        return implode('、', $enableDayInName);
    }
}
