<?php

use Mockery as m;
use \Echosign\Documents\OriginalDocument;

class OriginalDocumentTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $documents = m::mock('Echosign\Responses\Documents');

        $c = [
            'documentId' => '1234',
            'mimeType' =>'application/pdf',
            'name' =>'first_name'
        ];

        $d = new OriginalDocument($c, $documents);

        $this->assertEquals('1234', $d->getId());
        $this->assertEquals('application/pdf', $d->getMimeType());
        $this->assertEquals('first_name', $d->getName());
    }
}