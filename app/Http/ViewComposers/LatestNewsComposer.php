<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\ArticleRepository;

class LatestNewsComposer
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
    public function __construct(ArticleRepository $repository)
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
        $latestNews=$this->repository->getNewArticleList(3);

        $view->with('latestNews', $latestNews);
    }
}
