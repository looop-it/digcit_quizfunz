<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvType extends Model
{
    protected $table = 'adv_type';

    protected $fillable = [
        'title',
        'position',
        'size',
        '3rd_ad_code'
    ];

    public function type()
    {
        return $this->hasMany(AdvList::class, 'type_id', 'id');
    }
}
