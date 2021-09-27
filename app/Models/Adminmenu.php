<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adminmenu extends Model
{
    protected $table = 'admin_menu';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'order',
        'title',
        'icon',
        'uri'
    ];
}
