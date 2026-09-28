<?php

use App\Tool\Lang;
use App\Tool\Baidutransapi;
use Illuminate\Support\Facades\Cache;
use App\Models\Season;
use App\Models\QuestionCategory;
use App\Models\Scope;
use App\Repositories\WeeklyRankingRangeRepository;

function lang($name, $str = '')
{
    $Lang=new Lang(config('app.locale'), $str);

    $data1=$Lang->read($name);
    $from='auto';

    if ($data1) {
        return $data1;
    }

    if (config('app.locale')=='zh-HK') {
        $to='cht';
    }
    if (config('app.locale')=='en') {
        $to='en';
    }
    if (config('app.locale')=='zh-CN') {
        $to='zh';
        $from='cht';
    }

    $daidu_tr=new Baidutransapi($Lang);

    //$re=$daidu_tr->translate($name,$from,$to);
    $re = '';

    if ($re) {
        return $re;
    } else {
        return $name;
    }
}

/**
 * Get current open season
 *
 */
if (!function_exists('season')) {
    function season()
    {
        $selected = selectedSeason();

        if ($selected) {
            return $selected;
        }

        return Cache::remember('current_season', 60, function () {
            return Season::open()->latest()->first();
        });
    }
}

if (!function_exists('openSeasons')) {
    function openSeasons()
    {
        return Cache::remember('open_seasons', 60, function () {
            return Season::open()->orderBy('id', 'desc')->get();
        });
    }
}

if (!function_exists('selectedSeason')) {
    function selectedSeason()
    {
        if (app()->runningInConsole() || !app()->bound('session')) {
            return null;
        }

        $session = session();

        if (!$session->isStarted()) {
            return null;
        }

        $id = $session->get('competition_season_id');

        if (!$id) {
            return null;
        }

        $season = Season::open()->where('id', $id)->first();

        if (!$season) {
            $session->forget('competition_season_id');

            return null;
        }

        return $season;
    }
}

/**
 * Get current open season
 *
 */
if (!function_exists('latestSeason')) {
    function latestSeason()
    {
        return Cache::remember('latest_season', 60, function () {
            return Season::whereIn('status', ['open', 'closed'])
                        ->orderBy('id', 'desc')
                        ->first();
        });
    }
}

/**
 * Get all question categories.
 *
 */
if (!function_exists('questionCategory')) {
    function questionCategory()
    {
        return Cache::remember('question_category', 1440, function () {
            return QuestionCategory::all();
        });
    }
}


/**
 * Get all question categories.
 *
 */
if (!function_exists('questionScope')) {
    function questionScope()
    {
        return Cache::remember('question_scope', 1440, function () {
            return Scope::all();
        });
    }
}

/**
 * Get SSO url for login & register
 *
 */
if (!function_exists('sso_url')) {
    function sso_url(string $action, string $redirectUrl = null)
    {
        $appId = config('sso.access_key');

        if (!$appId) {
            abort(500, 'SSO access key is not defined');
        }

        $callbackUrl = config('sso.callback_url');

        if (!$callbackUrl) {
            abort(500, "SSO callback url is not defined");
        }

        $queryParams = [
            'action' => $action,
            'responseType' => 'json',
            'appId' => $appId,
            'callback' => $callbackUrl,
        ];

        if ($redirectUrl) {
            $queryParams = array_merge($queryParams, [
                'redirectUrl' => $redirectUrl
            ]);
        }

        return config('sso.url') . "/redirect?" . http_build_query($queryParams);
    }
}

if (!function_exists('weekly_ranking_range')) {
    function weekly_ranking_range()
    {
        $repository = new WeeklyRankingRangeRepository();

        return $repository->getRange();
    }
}
