<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $connection= 'membership';

    const TYPE_SECONDARY = 'secondary';
    const TYPE_UNIVERSITY = 'university';

    public static $type = [
        self::TYPE_SECONDARY => '中學',
        self::TYPE_UNIVERSITY => '大學',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'fax',
        'code',
        'approved',
        'student',
        'expected_participant',
        'actual_participant',
        'token',
        'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'approved' => 'boolean',
    ];

    public function students()
    {
        return $this->hasMany(Participant::class);
    }

    public function basicScores()
    {
        return $this->hasManyThrough(BasicScore::class, Participant::class);
    }
    
    public function contacts()
    {
        return $this->hasMany(SchoolRegistration::class, 'school_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function isApproved()
    {
        return $this->approved;
    }

    public function teachers()
    {
        return $this->hasMany(SchoolRegistration::class);
    }
}
