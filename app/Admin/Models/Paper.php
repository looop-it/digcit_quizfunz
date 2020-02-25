<?php

namespace App\Admin\Models;

use App\Models\Paper as BasePaper;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Paper extends BasePaper
{
    use ModelTree, AdminBuilder;

    protected $table = 'papers';

    protected $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();

        // Model creating event
        static::creating(function ($model) {

            // Generate Paper No
            if (!$model->no) {
                $model->no = static::generatePaperNo();
                if (!$model->no) {
                    // Stop create paper if fail
                    return false;
                }
            }
        });
    }

    // Generate paper no for reference
    public static function generatePaperNo()
    {
        $prefix = date('Ymd');
        for ($i = 0; $i < 10; $i++) {
            $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            if (!static::query()->where('no', $no)->exists()) {
                return $no;
            }
            usleep(100);
        }
        \Log::warning(sprintf('Paper no generate failed'));

        return false;
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


    public function season()
    {

        return $this->belongsTo(Season::class, 'season_id', 'id');
    }

}
