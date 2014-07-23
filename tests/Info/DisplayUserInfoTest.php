<?php

use Echosign\Info\DisplayUserInfo;

class DisplayUserInfoTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $info = new DisplayUserInfo('balls','Mr. Dick');
        $a = $info->toArray();
        $this->assertEquals('balls', $a['company']);
        $this->assertEquals('Mr. Dick', $a['fullNameOrEmail']);
    }
}