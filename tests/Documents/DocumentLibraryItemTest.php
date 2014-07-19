<?php

use Mockery as m;
use Echosign\Documents\DocumentLibraryItem;

class DocumentLibraryItemTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $ld = m::mock('Echosign\LibraryDocument');
        $templateTypes = ['DOCUMENT'];
        $modifiedDate = new DateTime();
        $doc = new DocumentLibraryItem( $ld, '1234', $templateTypes, $modifiedDate->format( DateTime::W3C ), 'balls', 'SHARED');

        $this->assertEquals('1234', $doc->getLibraryDocumentId());
        $this->assertEquals( 'DOCUMENT', $doc->getLibraryTemplateTypes()[0]->getType());
        $this->assertInstanceOf('DateTime', $doc->getModifiedDate());
        $this->assertEquals('balls', $doc->getName());
        $this->assertEquals('SHARED', $doc->getScope()->getScope());
    }

}