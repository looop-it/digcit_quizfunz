<?php
namespace App\Repositories;

use App\Models\Post;

use Illuminate\Support\Facades\Cache;
use App\Models\Feature;
use Carbon\Carbon;

class PostRepository
{
    /**
     * Get promo articles by promo type   首頁獲取最新文章 featured=1
     * @param  String $promo_name promotion name
     * @return Collection         Posts collection
     */
 
    public function getNewArticleList($num)
    {
        return Cache::remember('getNewArticleList-featured_1-'.$num, config('competition.global.post_cache'), function () use ($num) {
            $promo=Post::published()->orderBy('published_at', 'desc')->take($num)->get();
        
            if ($promo) {
                return $promo;
            } else {
                return false;
            }
        });
    }

    /**
     * Get promo articles by promo type    获得单条推广文章      $promo_name展示类型的关键字
     * @param  String $promo_name promotion name
     * @return Collection         Posts collection
     */
    public function getPromo_dan($promo_name, $num = 1)
    {
        return Cache::remember('promoNews-'.$promo_name.'-'.$num, config('competition.global.post_cache'), function () use ($promo_name,$num) {
            $promo = Feature::where('title', $promo_name)->where('status', 1)->first();
        
            if ($promo) {
                return $promo->posts()->published()->with('category')->orderBy('order')->first();
            } else {
                return false;
            }
        });
    }

    public function getPromo($promo_name, $num = 5)
    {
        return Cache::remember('promoNews-'.$promo_name.'-'.$num, config('competition.global.post_cache'), function () use ($promo_name,$num) {
            $promo = Feature::where('title', $promo_name)->where('status', 1)->first();
            if ($promo) {
                return $promo->posts()->published()->with('category')->orderBy('order')->take($num)->get();
            } else {
                return false;
            }
        });
    }

    /**
     * Get updated Articles   获取最新发布的文章
     * @param  Int $category_id category id(default 0 for all categories)
     * @param  Int $period      day period(dafault 7day)
     * @return Collection       Posts collection
     */
    public function getArticles()
    {
        return Post::published()
            // ->whereIn('category_id', explode(',', $category_id))
            // ->where('published_at', '>=', Carbon::now()->subDay($period))
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->paginate(10);
    }

    public function getArticle($id)
    {
        return Cache::remember('getArticle-one-'.$id, config('competition.global.post_cache'), function () use ($id) {
            return Post::published()
                ->where('id', '=', $id)
                ->first();
        });
    }
}
