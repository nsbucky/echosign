<?php

use Mockery as m;
use Echosign\Events\LibDocumentHistoryEvent;

class LibDocumentHistoryEventTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $date = new DateTime();
        $config = [
            'synchronizationKey'=>12345,
            'participantEmail'=>'test2@test.com',
            'description'=>'none',
            'versionId'=>1234,
            'comment'=>'balls',
            'actingUserIpAddress'=>'192.168.1.1',
            'actingUserEmail'=>'test@test.com',
            'date' => $date->format(DateTime::W3C),
            'deviceLocation' => [
                'latitude' =>'2',
                'longitude' => '3'
            ],
            'type' =>'FAXIN_RECEIVED'
        ];

        $event = new LibDocumentHistoryEvent( $config );

        $this->assertEquals(12345, $event->synchronizationKey);
        $this->assertEquals('test2@test.com', $event->participantEmail);
        $this->assertEquals('none', $event->description);
        $this->assertInstanceOf('DateTime', $event->getDate());
        $this->assertEquals(1234, $event->versionId);
        $this->assertEquals('balls', $event->comment);
        $this->assertEquals('192.168.1.1', $event->actingUserIpAddress);
        $this->assertEquals('test@test.com', $event->actingUserEmail);
        $this->assertEquals(2, $event->getDeviceLocation()->getLatitude());
        $this->assertEquals(3, $event->getDeviceLocation()->getLongitude());
    }
}