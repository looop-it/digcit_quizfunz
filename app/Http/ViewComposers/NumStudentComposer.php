<?php

namespace App\Http\ViewComposers;

use Cache;
use Illuminate\View\View;
use App\Models\Paper;
use App\Models\BasicScore;

class NumStudentComposer
{
    /**
     * The PostRepository implementation.
     *
     * @var PostRepository
     */
    protected $repository;

    /**
     * Create a new PostRepository composer.
     *
     * @param  PostRepository  $repository
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $participants_count = Cache::remember('participants_count', 10, function () {
            return sprintf("%05d", BasicScore::count());
        });

        $view->with('NumStudents', $participants_count);
    }
}
