<?php

use Echosign\Documents\Document;
use Mockery as m;

class DocumentTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $config = [
            'name' =>'sample.pdf',
            'documentId' =>'12345abc',
            'mimeType'=>'application/pdf'
        ];

        $ad = m::mock('Echosign\Responses\AgreementDocuments');
        $doc = new Document( $config, $ad);

        $this->assertEquals( $config['name'], $doc->getName());
        $this->assertEquals( $config['documentId'], $doc->getId());
        $this->assertEquals( $config['mimeType'], $doc->getMimeType());
    }

}