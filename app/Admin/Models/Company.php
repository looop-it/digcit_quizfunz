<?php

namespace App\Admin\Models;

use App\Models\Company as BaseCompany;

class Company extends BaseCompany
{
    public static function boot()
    {
        parent::boot();

        // assign current admin user'id to user_id
        static::creating(function (Company $post) {
            self::clearCompanyCache();
        });

        // detach the features when post unpublished
        static::updated(function (Company $post) {

            self::clearCompanyCache();
        });

        // detach the features when post deleted
        static::deleting(function (Company $post) {

            self::clearCompanyCache();
        });
    }
}
