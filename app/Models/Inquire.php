<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Inquire extends Model
{
    use Notifiable;

    protected $table = 'inquire';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'email', 'school_name','tel','capacity','enquiry',
    ];

}
