<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

use App\Models\School;
use App\Models\Participant;

class ParticipantExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public $school;
    public $seasonId;

    public function __construct(School $school, int $seasonId)
    {
        $this->school = $school;
        $this->seasonId = $seasonId;
    }

    public function query()
    {
        return Participant::where('school_id', $this->school->id)
                        ->withCount([
                            'papers' => function ($query) {
                                $query->inSeason($this->seasonId)->finished();
                            }
                        ])->with([
                            'bestScores' => function ($query) {
                                $query->where('season_id', $this->seasonId);
                            }
                        ]);
    }

    public function headings(): array
    {
        return [
            '年級',
            '班別',
            '學生姓名',
            '作賽次數',
            '最佳成績（分）'
        ];
    }

    public function map($student): array
    {
        return [
            $student->grade,
            $student->class,
            $student->name,
            $student->papers_count ?? '0',
            (count($student->bestScores) > 0) ? $student->bestScores->first()->score : '0'
        ];
    }
}
