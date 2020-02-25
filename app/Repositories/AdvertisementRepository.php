<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\AdvList;
use App\Models\AdvType;
use Carbon\Carbon;

class AdvertisementRepository
{
    /**
     * Get advertisement list.   
     *
     * @return array
     */
    public function getList()
    {  
            
        return Cache::remember('advertisements', config('competition.global.ad_cache'), function () {
            return [
                'top-banner' => $this->getAdvertisementByType('上方廣告欄'),
                'center-left-ad' => $this->getAdvertisementByType('左側中置廣告欄'),
                'center-right-ad' => $this->getAdvertisementByType('右側中置廣告欄'),
                'main-slider' => $this->getAdvertisementByTypes('首頁輪播 ')
            ];
        });  
    }  
       
    /**
     * Get first advertisement of specific type.
     *
     * @param integer $typeId
     * @return Advertisement|null
     */
    private function getAdvertisementByType($title) : ?AdvList
    {

       $advType  = AdvType::where('status',1)->where('title','=',$title)->first(); 
       
        if($advType){
            return  AdvList::where('type_id',$advType->id)->where('status',1)->first();
//        return AdvList::active()
//                            ->ofType($advType->id)
//                            ->first();

        }else{
  
            return null;  
        }      

    }


    /**
     * Get first advertisement of specific type.
     *
     * @param integer $typeId
     * @return Advertisement|null
     */
    private function getAdvertisementByTypes($title)
    {

        $advType  = AdvType::where('status',1)->where('title','=',$title)->first();
        if($advType){
            //dd(AdvList::where('type_id',$advType->id)->get());exit;
            return  AdvList::where('type_id',$advType->id)->where('status',1)->get();
//            return AdvList::active()
//                ->ofType($advType->id)
//                ->get();

        }else{

            return null;
        }

    }

    /**
     * Get advertisement of specific type.
     *
     * @param integer $typeId
     * @return Advertisement
     */
    public function getADVlist($typeId = 1) : ?AdvList
    {
        return  AdvList::where('type_id',$typeId)->where('status',1)->get();
//        return AdvList::active()
//                            ->ofType($typeId)
//                            ->first();
    }
}
