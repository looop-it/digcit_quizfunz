<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\ArticleRepository;

class NewsController extends Controller
{
    /**
     * Get company info for dashboard setting.
     *
     * @return void
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @return \Illuminate\Http\Response
     * 新聞資訊
     */
    public function index()
    {
        $newsList = $this->articleRepository->getArticles();

        return view('home.news')->with([
            'page' => 'news',
            'newsList' => $newsList,
            'showNews' => false
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     * 新聞資訊詳情
     */
    public function newsDetail($id)
    {
        $newsdetail= $this->articleRepository->getArticle($id);

        Post::where('id', $id)->increment('hits');

        return response()->view('home.news-detail', compact('newsdetail'));
    }
}
