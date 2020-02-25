<?php

namespace App\Models;

use App\Models\AdvType;
use Illuminate\Database\Eloquent\Model;

class AdvList extends Model
{
    protected $table = 'adv_list';
    
    protected $fillable = [
        'title',
        'remark',
        'start_date',
        'end_date',
        'status'
    ];

    public function type()
    {
        return $this->belongsTo(AdvType::class, 'type_id', 'id');
    }
}
