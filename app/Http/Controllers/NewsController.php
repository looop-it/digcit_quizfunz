<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\PostRepository;

class NewsController extends Controller
{
    /**
     * Get company info for dashboard setting.
     *
     * @return void
     */
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\Response
     * 新聞資訊
     */
    public function index()
    {
        $newsList = $this->repository->getArticles();

        return view('news.index', compact('newsList'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     * 新聞資訊詳情
     */
    public function show($id)
    {
        $news = $this->repository->getArticle($id);

        Post::where('id', $id)->increment('hits');

        return view('news.detail', compact('news'));
    }
}
