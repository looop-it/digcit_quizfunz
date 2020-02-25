<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repositories\GlobalRepository;
use App\Models\Participant;
use App\Models\Paper;

class HomeController extends Controller
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

    /**
     * @return \Illuminate\Http\Response
     * 首页显示
     */
    public function index()
    {
        $id = Auth::id();
        $global=$this->globalRepository->getGlobal();

        return view(
            'home.index',
            compact(
                'global'
            )
        );
    }
}
