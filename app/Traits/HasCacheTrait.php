<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasCacheTrait
{
    public function __construct()
    {
        $this->clearCache();
    }

    public function clearCache()
    {
        if (!property_exists(__CLASS__, 'cacheKey') || $this->cacheKey == null) {
            throw new \Exception("property cacheKey is not defined in class " . __CLASS__);
        }

        Cache::forget($this->cacheKey);
    }
}
