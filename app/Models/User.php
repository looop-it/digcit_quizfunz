<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\StartChallengeNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Redis;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'source',
        'register_way',
        'mobile',
        'gender',
        'birthday',
        'verified',
        'verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function participant()
    {
        return $this->hasOne(Participant::class);
    }

    /**
     * Get the paper records associated with the user.
     */
    public function papers()
    {
        return $this->hasManyThrough(Paper::class, Participant::class);
    }

    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the start challenge notification.
     *
     * @return void
     */
    public function sendStartChallengeNotification()
    {
        $this->notify(
            (new StartChallengeNotification())->delay(now()->addMinutes(2))
        );
    }
    
    public function scopeCompetition($query)
    {
        return $query->where('source', 'quizfunz');
    }

    /**
     * Cache user's current processing paper id.
     *
     * @param int $id
     */
    public function setCurrentPaperId(int $id): void
    {
        $redis = Redis::connection('paper');

        $redis->set($this->getPaperCacheKey(), $id);
        $redis->expire($this->getPaperCacheKey(), 1550);
    }

    /**
     * Get user's current processing paper id.
     */
    public function getCurrentPaperId()
    {
        return Redis::connection('paper')->get($this->getPaperCacheKey());
    }

    /**
     * Remove user's paper id cache.
     */
    public function clearCurrentPaperId()
    {
        return Redis::connection('paper')->del($this->getPaperCacheKey());
    }

    private function getPaperCacheKey()
    {
        return "user:{$this->id}:paper_id";
    }

    public function canChallenge()
    {
        if ($this->withinSeasonTimeLimit() && $this->overSeasonTimeInterval()) {
            return true;
        }

        return false;
    }

    public function withinSeasonTimeLimit()
    {
        $season = season();

        if ($season) {
            $totalFinishedPapers = $this->papers()->inSeason($season->id)->finished()->count();

            if ($totalFinishedPapers == 0 || $totalFinishedPapers < $season->times_limit) {
                return true;
            }
        }

        return false;
    }

    public function overSeasonTimeInterval()
    {
        $season = season();

        if ($season) {
            $paper = $this->papers()->inSeason($season->id)->finished()->orderBy('finished_at', 'desc')->first();

            if ($paper) {
                $minutesLapsed = now()->diffInMinutes($paper->finished_at);

                if ($minutesLapsed < $season->time_interval) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }
}
