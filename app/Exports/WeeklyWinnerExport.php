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
    public $yearWeek;

    public function __construct($seasonId, $yearWeek, $title)
    {
        $this->seasonId = $seasonId;
        $this->yearWeek = $yearWeek;
        $this->title = $title;
    }

    public function view(): View
    {
        $rankingData = (new RankingManager())->setSeasonId($this->seasonId)->getAllRanking();

        return view('excel.weekly_winner', [
            'title' => $this->title,
            'rankings' => $rankingData['personal_weekly']["{$this->yearWeek}"]
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
