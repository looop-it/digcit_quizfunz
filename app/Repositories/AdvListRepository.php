<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\AdvList;
use App\Models\AdvType;    
use Carbon\Carbon;
   
class AdvListRepository  
{  
    /**
     * Get Hot Articles
     * @param  Int $category_id category id(default 0 for all categories)
     * @param  Int $period      day period(dafault 7day)
     * @param  Int $num         return articles(default 10)
     * @return Collection       Posts collection
     */
    public function getADV($type_id = 0)   
    {

        return Cache::remember('avd-'.$type_id, config('competition.global.ad_cache'), function () use ($type_id) {
             $advType = AdvType::where('status','1')->find($type_id);         
            if ($advType) {
                     return  AdvList::where('type_id',$type_id)->get();
            } else {
                return false;  
            }
        });
    }
       
    /**
     * Get Hot Articles
     * @param  Int $type_id      adv_list  type_id(dafault 1)
     * @return Collection       Posts collection
     */
    public function getADVlist($type_id = 1)
    {
        return Cache::remember('avd-'.$type_id, config('competition.global.ad_cache'), function () use ($type_id) {
            return DB::table("adv_list")
            ->where('type_id','=',$type_id)
            ->where('status','=',1)
            ->first();
        });
    }
}
