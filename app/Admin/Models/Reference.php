<?php

namespace App\Admin\Models;

/*use Illuminate\Database\Eloquent\SoftDeletes;*/
use App\Models\Reference as BaseReference;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Reference extends BaseReference
{

   /* use SoftDeletes;*/
    use ModelTree, AdminBuilder;
    protected $table = 'references';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'cover_image',
        'desc',
        'link',
        'status',
        'author',
        'hits',
        'content'
    ];

    /**
     *
     */
    public static function boot()
    {

        parent::boot();

        // detach the features and tags when post deleted
        static::deleting(function ($post) {

       //     $post->tags()->detach();
       //     $post->features()->detach();

        //    $post->topic_headlines()->delete();
        });


    }

    /**
     * @return bool|null
     * @throws \Exception
     *
     * 重寫
     */
    public function delete()
    {


        $this->where($this->primaryKey, $this->getKey())->delete();

        return parent::delete();
    }



}
