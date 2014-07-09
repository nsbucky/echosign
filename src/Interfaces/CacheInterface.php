<?php namespace Echosign\Interfaces;

interface CacheInterface {
    /**
     * @param string $key
     * @param string $value
     * @param integer $time seconds
     * @return void
     */
    public function put($key, $value, $time);

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param $key
     * @return void
     */
    public function forget($key);

    /**
     * @param $key
     * @return boolean
     */
    public function has($key);
}