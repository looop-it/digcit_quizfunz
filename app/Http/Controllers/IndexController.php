<?php

namespace App\Http\Controllers;

use App\Repositories\GlobalRepository;

class IndexController extends Controller
{
    public $globalRepository;

    /**
     * Get company info for dashboard setting.
     *
     * @return void
     */
    public function __construct(GlobalRepository $globalRepository)
    {
        parent::__construct();

        $this->globalRepository = $globalRepository;
    }

    public function index()
    {
        $global = $this->globalRepository->getGlobal();

        return view('index', compact('global'));
    }
}
