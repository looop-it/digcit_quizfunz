<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use App\Repositories\ReferenceRepository;

class ReferenceController extends Controller
{
    public $repository;

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

    public function show(Reference $reference)
    {
        return view('reference_detail', compact('reference'));
    }
}
