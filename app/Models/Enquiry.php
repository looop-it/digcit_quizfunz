<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Enquiry extends Model
{
    use Notifiable;

    protected $table = 'inquire';
    
    protected $fillable = [
        'name',
        'email',
        'school_name',
        'tel',
        'capacity',
        'enquiry',
    ];
}
