<?php

use Mockery as m;
use Echosign\Documents\SupportingDocument;

class SupportingDocumentTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $documents = m::mock('Echosign\Responses\AgreementDocuments');
        $c = [
            'displayLabel' => 'balls',
            'supportingDocumentId' => '1234',
            'mimeType' =>'application/pdf',
            'fieldName' =>'first_name'
        ];

        $lib = new SupportingDocument($c, $documents);

        $this->assertEquals('balls', $lib->getDisplayLabel());
        $this->assertEquals('1234', $lib->getId());
        $this->assertEquals('application/pdf', $lib->getMimeType());
        $this->assertEquals('first_name', $lib->getFieldName());
    }
}