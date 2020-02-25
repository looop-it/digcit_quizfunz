<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class Company extends Model
{
    protected $table = 'global';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'website_name',
        'slogan',
        'logo',
        'css_file',
        'phone_number',
        'cell_phone',
        'address',
        'theme',
        'state',
        'city',
        'zip_code',
        'email',
        'contact_email',
        'sales_email',
        'support_email',
        'status',
        'twitter',
        'facebook',
        'facebook_app_id',
        'description',
        'keywords',
        'about_us',
        'refund_policy',
        'privacy_policy',
        'terms_of_service',
        'android_app_url',
        'ios_app_url',
        'app_info_url'
    ];

    /**
     * @param $paper_id
     * @return mixed
     * 清除緩存
     */
    public static function clearCompanyCache()
    {
        return Cache::forget('getglobal--website');
    }
}
