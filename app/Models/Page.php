<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
   // use SoftDeletes;
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $table = 'pages';
    protected $fillable = [
        'name',
        'slug',
        'content',
        'status',
    ];
}
