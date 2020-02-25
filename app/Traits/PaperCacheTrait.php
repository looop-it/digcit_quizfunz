<?php

namespace App\Traits;

use ArrayAccess;
use InvalidArgumentException;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

trait PaperCacheTrait
{
    public static function create($data = null)
    {
        if ($data == null) {
            return null;
        }
        $instance = new static;
        foreach ($data as $key => $value) {
            $instance[$key] = $value;
        }
        return $instance;
    }

    /**
     * Add findFromCache function
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        if ($method == 'find') {
            // Load from Cache
            $obj = static::create(json_decode(Redis::get(static::getCacheKey($parameters[0])), true));
            if (null == $obj) {
                $obj = (new static)->$method(...$parameters);
                if (null == $obj) {
                    return null;
                } else {
                    $key = static::getCacheKey($parameters[0]);
                    // Set cache and expire to 20 minutes
                    Redis::set($key, $obj);
                    Redis::expire($key, 20*60);
                    return $obj;
                }
            } else {
                $obj->exists = true;
                return $obj;
            }
        } elseif ($method == 'findNoCache') {
            $method = 'find';
            return (new static)->$method(...$parameters);
        }

        return (new static)->$method(...$parameters);
    }

    private static function getCacheKey($id)
    {
        $name = str_replace('\\', ':', __CLASS__);
        return "{$name}_{$id}";
    }

    private static function clearCache($id)
    {
        Redis::del(self::getCacheKey($id));
    }

    /**
     * when save, should clear cache
     * @param array $options
     */
    public function save(array $options = [])
    {
        static::clearCache($this[$this->primaryKey]);
        return parent::save($options);
    }
}
