<?php

use Echosign\Credentials\User;

class UserCredentialTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $u = new User('balls','dong','chin');
        $a = $u->toArray();
        $this->assertEquals('balls', $a['apiKey']);
        $this->assertEquals('dong', $a['email']);
        $this->assertEquals('chin', $a['password']);
    }

}