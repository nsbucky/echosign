<?php

use Echosign\Credentials\Reminder;

class ReminderCredentialTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $r = new Reminder('balls','dong');
        $this->assertEquals('balls', $r->getAgreementId());
        $this->assertEquals('dong', $r->getComment());
    }

}