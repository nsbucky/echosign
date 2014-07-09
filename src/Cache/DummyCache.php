<?php namespace Echosign\Cache;

use Echosign\Interfaces\CacheInterface;

class DummyCache implements CacheInterface {

    protected $cache = [];

    /**
     * @param string $key
     * @param string $value
     * @param integer $time
     * @return void
     */
    public function put($key, $value, $time)
    {
        $this->cache[$key] = [$value, time() + $time];
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if( ! array_key_exists($key, $this->cache) ) return false;

        list($value, $time) = $this->cache[$key];

        // expired
        if( time() > $time ) return false;

        // still valid
        if( time() < $time) return $value;
    }

    /**
     * @param $key
     * @return void
     */
    public function forget($key)
    {
        unset($this->cache[$key]);
    }

    /**
     * @param $key
     * @return boolean
     */
    public function has($key)
    {
        if( ! array_key_exists($key, $this->cache) ) return false;

        list($value, $time) = $this->cache[$key];

        // expired
        if( time() > $time ) return false;

        // still valid
        if( time() < $time) return true;
    }

}