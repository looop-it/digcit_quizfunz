<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\GlobalRepository;

class FootComposer
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
    public function __construct(GlobalRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $pages=$this->repository->getInfo(10);

        $view->with('pages', $pages);
    }
}
  