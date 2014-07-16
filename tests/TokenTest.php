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
        $request->shouldReceive('post')->andReturn([
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
        $request->shouldReceive('post')->andReturn(new Echosign\Responses\Error(400,'INVALID_APP','An invalid application ID or secret was specified.'));

        $token = new \Echosign\Token( $this->config['appID'], $this->config['secret'], $this->config['apiKey']);
        $token->setTransport( $request );
        $response = $token->authenticate();
        $this->assertInstanceOf('Echosign\Responses\Error', $response);
        $this->assertEquals( 'INVALID_APP', $response->getCode() );
    }

    public function testCacheToken()
    {
        $request = m::mock('Echosign\Transports\Guzzle');
        $request->shouldReceive('post')->once()->andReturn([
            'accessToken'=>'12345abc',
            'expiresIn'=>10,
        ]);

        $token = new \Echosign\Token( $this->config['appID'], $this->config['secret'], $this->config['apiKey']);
        $token->setTransport( $request );
        $token->setCacheHandler( new \Echosign\Cache\DummyCache() );
        $this->assertTrue($token->authenticate());
        $this->assertEquals('12345abc', $token->getAccessToken());
        $this->assertEquals(10, $token->getExpiresIn());
        $this->assertTrue($token->authenticate());
        $this->assertTrue( $token->isAuthenticated() );
    }

    public function testCacheTokenExpired()
    {
        $request = m::mock('Echosign\Transports\Guzzle');
        $request->shouldReceive('post')->twice()->andReturn([
            'accessToken'=>'12345abc',
            'expiresIn'=>1,
        ]);

        $token = new \Echosign\Token( $this->config['appID'], $this->config['secret'], $this->config['apiKey']);
        $token->setTransport( $request );
        $token->setCacheHandler( new \Echosign\Cache\DummyCache() );
        $this->assertTrue($token->authenticate());
        $this->assertEquals('12345abc', $token->getAccessToken());
        $this->assertEquals(1, $token->getExpiresIn());
        sleep(1);
        $this->assertTrue($token->authenticate());
        $this->assertTrue( $token->isAuthenticated() );
    }

}
