<?php

use Echosign\Info\CounterSignerInfo;
use Mockery as m;

class CounterSignerInfoTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $mock = m::mock('Echosign\Options\WidgetSignerSecurityOption');
        $mock->shouldReceive('toArray')->andReturn([
            'password' =>'balls'
        ]);

        $info = new CounterSignerInfo('test@test.com','SIGNER', $mock);

        $this->assertEquals('SIGNER', $info->getRole());

        $a = $info->toArray();

        $this->assertEquals('balls', $a['securityOptions'][0]['password']);
        $this->assertEquals('test@test.com', $a['email']);

    }

}