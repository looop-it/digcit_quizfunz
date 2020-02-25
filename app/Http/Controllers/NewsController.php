<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\ArticleRepository;

/**

资讯

*/
class NewsController extends Controller
{
  
    /**
     * Get company info for dashboard setting.
     *
     * @return void
     */
    public function __construct(ArticleRepository $ArticleRepository)
    {
        parent::__construct();
        $this->ArticleRepository = $ArticleRepository;
    }

    /**
     * @return \Illuminate\Http\Response
     * 新聞資訊
     */
    public function index()
    {


// 资讯
        $ArticeList=$this->ArticleRepository->getArticles();




        //输出数据

        return response()->view('home.news', compact('ArticeList'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     * 新聞資訊詳情
     */
    public function newsDetail($id)
    {
        $newsdetail= $this->ArticleRepository->getArticle($id);
        Post::where('id', $id)->increment('hits');
        return response()->view('home.news-detail', compact('newsdetail'));
    }
}
