<?php

use Mockery as m;
use Echosign\Documents\LibDocSupportingDocument;

class LibDocSupportingDocumentTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $documents = m::mock('Echosign\Responses\Documents');
        $c = [
            'displayLabel' => 'balls',
            'supportingDocumentId' => '1234',
            'mimeType' =>'application/pdf',
            'fieldName' =>'first_name'
        ];

        $lib = new LibDocSupportingDocument($c, $documents);

        $this->assertEquals('balls', $lib->getDisplayLabel());
        $this->assertEquals('1234', $lib->getId());
        $this->assertEquals('application/pdf', $lib->getMimeType());
        $this->assertEquals('first_name', $lib->getFieldName());
    }
}