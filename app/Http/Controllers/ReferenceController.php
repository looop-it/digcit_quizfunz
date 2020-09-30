<?php

namespace App\Http\Controllers;

use App\Repositories\ReferenceRepository;

class ReferenceController extends Controller
{
    public $repository;

    /**
     * Get company info for dashboard setting.
     *
     * @return void
     */
    public function __construct(ReferenceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\Response
     *
     */

    public function index()
    {
        $references = $this->repository->getReferences(10);
    
        return view('reference')->with([
            'showNews' => true,
            'page' => 'reference',
            'references' => $references,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     *
     *
     */
    public function show($id)
    {
        $reference = $this->repository->getReference($id);
        
        return view('reference_detail', compact('reference'));
    }
}
