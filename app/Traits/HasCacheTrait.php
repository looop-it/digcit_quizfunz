<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasCacheTrait
{
    public function __construct()
    {
        parent::__construct();

        $this->clearCache();
    }

    public function clearCache()
    {
        if (property_exists(__CLASS__, 'cacheKey') && $this->cacheKey == null) {
            Cache::forget($this->cacheKey);
        }
        
        throw new \Exception("property cacheKey is not defined in class " . __CLASS__);
    }
}
