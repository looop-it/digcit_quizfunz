<?php

namespace App\Helpers;

use App\Models\Season;
use App\Models\School;
use App\Exports\ParticipantExport;
use Illuminate\Support\Facades\Storage;

class ReportManager
{
    private const STORAGE = 'reports';

    private $date;
    private $season;
    private $school;

    public function __construct()
    {
        $this->date = now()->format('Y_m_d');
    }

    public function setSeason(int $seasonId)
    {
        $this->season = $seasonId;

        return $this;
    }

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function setSchool(School $school)
    {
        $this->school = $school;

        return $this;
    }

    public function generate()
    {
        (new ParticipantExport($this->school, $this->season))->store($this->path(), self::STORAGE);
    }

    public function get()
    {
        return Storage::disk(self::STORAGE)->get($this->path());
    }

    private function path()
    {
        return "daily_reports/season_{$this->season}/{$this->school->name}/{$this->date}.xlsx";
    }
}
