<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use App\Models\Company;
use App\Models\Page;
use App\Models\Sponsor;
use App\Models\School;

class GlobalRepository
{
    /**
     * 获取网站配置
     * @return Collection       Posts collection
     */
    public static function getGlobal()
    {
        return Cache::remember('getglobal--website', config('competition.global.global_cache'), function () {
            return Company::where('id', 1)->first();
        });
    }
 

    public static function getSponsors($num = 10)
    {
        return Cache::remember('getSponsors-all--'.$num, config('competition.global.sponsors_cache'), function () use ($num) {
            return Sponsor::where('status', '=', 1)
                ->orderBy('id', 'asc')
                ->take($num)
                ->get();
        });
    }

    public static function getSchools()
    {
        return Cache::remember('getSchools-all--School', config('competition.global.school_cache'), function () {
            return School::where('approved', '=', 1)
                ->orderBy('id', 'asc')
                ->get();
        });
    }
    /**
     * Get Hot Articles
     * @param  Int $category_id category id(default 0 for all categories)
     * @param  Int $num         return articles(default 10)
     * @return Collection       Posts collection
     */
    public static function getInfo($num = 10)
    {
        return Cache::remember('getInfo-all--'.$num, config('competition.global.page_cache'), function () use ($num) {
            return Page::where('status', '=', 1)
                ->orderBy('id', 'asc')
                ->take($num)
                ->get();
        });
    }
    /**
     * Get Hot Articles
     * @param  Int $category_id category id(default 0 for all categories)
     * @param  Int $num         return articles(default 10)
     * @return Collection       Posts collection
     */
    public static function getInfo_one($id=1)
    {
        return Cache::remember('getInfo-all--'.$id, config('competition.global.page_cache'), function () use ($id) {
            return  $object= Page::where('status', '=', 1)
                ->where('slug', '=', $id)
                ->first();
        });
    }

    public static function getpage_one()
    {
        return Cache::remember('getpage_one-all--first', config('competition.global.page_cache'), function () {
            $object= Page::where('status', '=', 1)
                ->orderBy('id', 'asc')
                ->first();
            return  $object;
        });
    }
}
