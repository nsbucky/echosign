<?php

use Mockery as m;
use Echosign\Info\AgreementCreationInfo;

class AgreementCreationInfoTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $doc = m::mock('Echosign\Info\DocumentCreationInfo');
        $doc->shouldReceive('toArray')
            ->andReturn(['locale' => 'EN_US']);

        $opt = m::mock('Echosign\Options\InteractiveOptions');
        $opt->shouldReceive('toArray')
            ->andReturn(['noChrome'=>true]);

        $info = new AgreementCreationInfo( $doc, $opt);

        $a = $info->toArray();

        $this->assertEquals('EN_US', $a['documentCreationInfo']['locale']);
        $this->assertTrue($a['options']['noChrome']);
    }

}