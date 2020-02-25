<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\AdvList;
use App\Models\Reference;
use Carbon\Carbon;

class ReferenceRepository
{
    /**
     * Get Hot Articles
     * @param  Int $category_id category id(default 0 for all categories)
     * @param  Int $period      day period(dafault 7day)
     * @param  Int $num         return articles(default 10)
     * @return Collection       Posts collection
     */

    public function getReferences($num = 10)
    {
        return Cache::remember('getReferences-0'.$num, config('competition.global.reference_cache'), function () use ($num) {
            return Reference::active()->orderBy('updated_at', 'desc')->paginate($num);
        });
    }

    public function getReference($id)
    {
        return Cache::remember('getReference-'.$id, config('competition.global.reference_cache'), function () use ($id) {
            return Reference::active()->where('id', $id)->orderBy('updated_at', 'desc')->first();
        });
    }
}
