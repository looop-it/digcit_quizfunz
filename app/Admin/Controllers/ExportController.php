<?php

namespace App\Admin\Controllers;

use App\Exports\WeeklyWinnerExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        return Excel::download(new WeeklyWinnerExport(
            $request->season_id,
            $request->school_type,
            $request->year,
            $request->week
        ), "每周最強知識王_{$request->year}_{$request->week}.xlsx");
    }
}
