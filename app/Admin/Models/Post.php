<?php

namespace App\Admin\Models;

use App\Models\Post as BasePost;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Auth\Database\Administrator;
use App\Helpers\Utility;

class Post extends BasePost
{
    use ModelTree, AdminBuilder;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function save(array $options = [])
    {
        // set default slug
        if (!$this->slug) {
            $this->slug = Utility::makeSlug($this->title);
        }
        // confirm video article mark
        //  var_dump(Utility::isVideoPost($this->video_url));exit;
        /*         if (Utility::isVideoPost($this->video_url)) {
                    $this->video = 1;
                } else {
                    $this->video = 0;
                } */
        //   print_r( $this->video);exit;
        //save excerpt form editor content
          
        $this->excerpt = Utility::makeExcerpt($this->content);

        parent::save();
    }

    public static function boot()
    {
        parent::boot();

        // assign current admin user'id to user_id
        static::creating(function (Post $post) {
            $post->user_id = Admin::user()->id;
        });

        // assign current admin user'id to last_modified_user
        static::updating(function (Post $post) {
            $post->last_modify_user = Admin::user() ? Admin::user()->id : null;

            $post->slug = Utility::makeSlug($post->title);
        });

        // detach the features when post unpublished
        static::updated(function (Post $post) {

            // dd($post);

            // if ($post->isDirty('published') && $post->published == 0) {
            //     $post->features()->detach();
            // }
        });

        // detach the features when post deleted
        static::deleting(function (Post $post) {

            $post->feature()->delete();
            //  $post->features()->detach();
        });
    }

    // related to system admin user
    public function initEditor()
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }

    // related to system admin user
    public function lastModifyEditor()
    {
        return $this->belongsTo(Administrator::class, 'last_modify_user');
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
