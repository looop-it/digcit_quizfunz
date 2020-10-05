<?php

namespace App\Http\Controllers;

use App\Repositories\GlobalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    /**
     * Get company info for dashboard setting.
     */
    public function __construct(GlobalRepository $GlobalRepository)
    {
        $this->GlobalRepository = $GlobalRepository;
    }

    /**
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     *                                   單頁面
     */
    public function index($slug = '')
    {
        if ($slug == '') {
            $page = $this->GlobalRepository->getpage_one();
        } else {
            $page = $this->GlobalRepository->getInfo_one($slug);
        }

        return view(
            'page',
            compact(
                'page',
                'slug'
            )
        );
    }
}
