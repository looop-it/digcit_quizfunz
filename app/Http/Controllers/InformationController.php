<?php

namespace App\Http\Controllers;

use App\Models\CompetitionInfo;

class InformationController extends Controller
{
    public function index()
    {
        $competitions = CompetitionInfo::with(['children' => function ($query) {
            $query->active()->orderBy('order', 'asc');
        }])
        ->ofParent(0)
        ->active()
        ->orderBy('order', 'asc')
        ->get();
        
        return view('home.information')->with([
            'page' => 'information',
            'showNews' => true,
            'competitions' => $competitions
        ]);
    }
}
