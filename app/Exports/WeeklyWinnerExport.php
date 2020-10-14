<?php

namespace App\Exports;

use App\Helpers\RankingManager;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WeeklyWinnerExport implements FromView, WithStyles, ShouldAutoSize
{
    public $seasonId;
    public $schoolType;
    public $year;
    public $week;

    public function __construct($seasonId, $schoolType, $year, $week)
    {
        $this->seasonId = $seasonId;
        $this->schoolType = $schoolType;
        $this->year = $year;
        $this->week = $week;
    }

    public function view(): View
    {
        $rankingData = (new RankingManager())->setSeasonId($this->seasonId)->getAllRanking();
        $weekRange = config('competition.weekly_ranking_range')[$this->year][$this->week];

        return view('excel.weekly_winner', [
            'title' => "每周最強知識王({$this->year}年第{$this->week}週 {$weekRange['start_date']}至{$weekRange['end_date']})",
            'rankings' => $rankingData['personal_weekly'][$this->schoolType]["{$this->year}_{$this->week}"]
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
        ];
    }
}
