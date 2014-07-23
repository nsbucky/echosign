<?php

use Echosign\Info\DeviceLocation;

class WidgetDeviceLocationTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $d = new DeviceLocation(2,3);
        $this->assertEquals(2, $d->getLatitude());
        $this->assertEquals(3, $d->getLongitude());
    }
}