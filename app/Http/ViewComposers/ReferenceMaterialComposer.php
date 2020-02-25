<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\ReferenceRepository;

class ReferenceMaterialComposer
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
    public function __construct(ReferenceRepository $repository)
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
        $references = $this->repository->getReferences(3);

        $view->with('references', $references);
    }
}
