<?php namespace Echosign\Cache;

use Echosign\Interfaces\CacheInterface;

class LaravelCache implements CacheInterface {

    public function put($key, $value, $time)
    {
        return \Cache::put($key, $value, $time);
    }

    public function get($key, $default = null)
    {
        return \Cache::get($key, $default);
    }

    public function forget($key)
    {
        return \Cache::forget($key);
    }

    public function has($key)
    {
        return \Cache::has( $key );
    }


}