<?php

namespace App\Http\Controllers;

use App\Repositories\AdvertisementRepository;

class IndexController extends Controller
{
    public function __construct(AdvertisementRepository $advRepository)
    {
        $this->advRepository = $advRepository;
    }

    public function index()
    {
        $advertisements = $this->advRepository->getList();

        return view('index', compact('advertisements'));
    }
}
