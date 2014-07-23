<?php

use Echosign\Info\AgreementStatusUpdateInfo;

class AgreementStatusUpdateInfoTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $info = new AgreementStatusUpdateInfo('balls',true);
        $a = $info->toArray();

        $this->assertTrue( $a['notifySigner']);
        $this->assertEquals('cancel', $a['value']);
        $this->assertEquals('balls', $a['comment']);
    }

}