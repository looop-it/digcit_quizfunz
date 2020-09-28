<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        return view('index')->with([
            'page' => 'index',
            'showNews' => true
        ]);
    }
}
