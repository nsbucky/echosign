<?php

use Mockery as m;

class ReminderTest extends PHPUnit_Framework_TestCase {

    public $config;
    public $token;

    public function __construct()
    {
        $this->config = require_once __DIR__. '/../echosign-auth.php';
        $this->token = m::mock('Echosign\Token');
        $this->token->shouldReceive('getAccessToken')->andReturn('12345abc');
    }

    public function testConstruct()
    {
        $reminder = new \Echosign\Reminder($this->token, 'abc123','no comment');

        $this->assertEquals('abc123', $reminder->getCredentials()->getAgreementId());
        $this->assertEquals('no comment', $reminder->getCredentials()->getComment());
    }

    public function testCreate()
    {
        $returnJson = '{
              "result": "SUCCESS",
              "recipientEmail": "test@test.com"
        }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('post')->andReturn( json_decode( $returnJson, true) );

        $agreement = new \Echosign\Reminder($this->token, 'abcs1123');
        $agreement->setTransport($transport);

        $created = $agreement->create();

        $this->assertInstanceOf('Echosign\Responses\ReminderCreationResult', $created);


        $this->assertEquals("SUCCESS", $created->result);
        $this->assertEquals("test@test.com", $created->recipientEmail);
    }
}