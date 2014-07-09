<?php

use Mockery as m;

class TokenTest extends PHPUnit_Framework_TestCase {

    public $config;

    public function __construct()
    {
        $this->config = require_once __DIR__. '/../echosign-auth.php';
    }

    public function testConstruct()
    {
        $token = new \Echosign\Token( $this->config['appID'], $this->config['secret'], $this->config['apiKey']);

        $this->assertInstanceOf('Echosign\Credentials\User', $token->getUser() );
        $this->assertInstanceOf('Echosign\Credentials\Application', $token->getApplication() );
    }

    public function testAuthenticate()
    {
        $request = m::mock('Echosign\Transports\Guzzle');
        $request->shouldReceive('get')->andReturn([
            'accessToken'=>'12345abc',
            'expiresIn'=>123,
        ]);

        $token = new \Echosign\Token( $this->config['appID'], $this->config['secret'], $this->config['apiKey']);
        $token->setTransport( $request );
        $this->assertTrue($token->authenticate());
        $this->assertEquals('12345abc', $token->getAccessToken());
        $this->assertEquals(123, $token->getExpiresIn());

        $this->assertTrue( $token->isAuthenticated() );
    }

    public function testAuthenticateGivesError()
    {
        $request = m::mock('Echosign\Transports\Guzzle');
        $request->shouldReceive('get')->andReturn(new Echosign\Responses\Error('INVALID_APP','An invalid application ID or secret was specified.'));

        $token = new \Echosign\Token( $this->config['appID'], $this->config['secret'], $this->config['apiKey']);
        $token->setTransport( $request );
        $response = $token->authenticate();
        $this->assertInstanceOf('Echosign\Responses\Error', $response);
        $this->assertEquals( 'INVALID_APP', $response->getCode() );
    }

    public function testCacheToken()
    {
        $request = m::mock('Echosign\Transports\Guzzle');
        $request->shouldReceive('get')->once()->andReturn([
            'accessToken'=>'12345abc',
            'expiresIn'=>10,
        ]);

        $token = new \Echosign\Token( $this->config['appID'], $this->config['secret'], $this->config['apiKey']);
        $token->setTransport( $request );
        $token->setCacheHandler( new DummyCache() );
        $this->assertTrue($token->authenticate());
        $this->assertEquals('12345abc', $token->getAccessToken());
        $this->assertEquals(10, $token->getExpiresIn());
        $this->assertTrue($token->authenticate());
        $this->assertTrue( $token->isAuthenticated() );
    }

    public function testCacheTokenExpired()
    {
        $request = m::mock('Echosign\Transports\Guzzle');
        $request->shouldReceive('get')->twice()->andReturn([
            'accessToken'=>'12345abc',
            'expiresIn'=>1,
        ]);

        $token = new \Echosign\Token( $this->config['appID'], $this->config['secret'], $this->config['apiKey']);
        $token->setTransport( $request );
        $token->setCacheHandler( new DummyCache() );
        $this->assertTrue($token->authenticate());
        $this->assertEquals('12345abc', $token->getAccessToken());
        $this->assertEquals(1, $token->getExpiresIn());
        sleep(1);
        $this->assertTrue($token->authenticate());
        $this->assertTrue( $token->isAuthenticated() );
    }

}


class DummyCache implements \Echosign\Interfaces\CacheInterface {

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