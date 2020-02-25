<?php


use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use App\Admin\Models\Posts;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use App\Tool\Lang;
use App\Tool\Google;
use App\Tool\Baidutransapi;
use Illuminate\Support\Facades\Cache;
use App\Models\Season;
use App\Models\QuestionCategory;

/**
 * 方法一：获取随机字符串
 * @param number $length 长度
 * @param string $type 类型
 * @param number $convert 转换大小写
 * @return string 随机字符串
 */
function random($length = 6, $type = 'string', $convert = 0)
{
    $config = array(
        'number' => '1234567890',
        'letter' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string' => 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        'hehele'=>'~!#$@%^&*()_+|}{]['
    );

    if (!isset($config[$type])) {
        $type = 'string';
    }
    $string = $config[$type];

    $code = '';
    $strlen = strlen($string) - 1;
    for ($i = 0; $i < $length; $i++) {
        $code .= $string{mt_rand(0, $strlen)};
    }
    if (!empty($convert)) {
        $code = ($convert > 0) ? strtoupper($code) : strtolower($code);
    }
    return $code;
}


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
        return Cache::remember('current_season', 60, function () {
            return Season::open()->latest()->first();
        });
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
