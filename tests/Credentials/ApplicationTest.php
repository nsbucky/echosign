<?php

use Echosign\Credentials\Application;

class ApplicationTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $app = new Application('balls','dong');
        $array = $app->toArray();
        $this->assertEquals('balls', $array['applicationSecret']);
        $this->assertEquals('dong', $array['applicationId']);
    }

}