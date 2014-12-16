<?php

use Echosign\Info\DocumentCreationInfo;
use Echosign\Info\RecipientInfo;
use Mockery as m;

class DocumentCreationInfoTest extends PHPUnit_Framework_TestCase {

    public function testCreate()
    {
        $file = m::mock('Echosign\Info\FileInfo');
        $file->shouldReceive('toArray')->andReturn([
            'libraryDocumentId'=>'1234abcd'
        ]);

        $opt = m::mock('Echosign\Options\SecurityOption');
        $opt->shouldReceive('toArray')->andReturn([
            'passwordProtection'=>true,
        ]);

        $r = new RecipientInfo('test@test.com');
        $m = new \Echosign\Info\MergefieldInfo(1, 'first_name');

        $doc = new DocumentCreationInfo( $file, 'joe', 'ESIGN', 'SENDER_SIGNATURE_NOT_REQUIRED' );

        $doc->setMessage('message');
        $doc->setLocale('EN_US');
        $doc->setDeadline(3);
        $doc->setCallBackInfo('http://hardbears.com');
        $doc->setSignatureType('ESIGN');
        $doc->setSignatureFlow('SENDER_SIGNS_LAST');
        $doc->addFormFieldLayerTemplate($file);
        $doc->addSecurityOption( $opt );
        $doc->addRecipients($r);
        $doc->addRecipient('r@test.com');
        $doc->addCC('cc@test.com');
        $doc->addMergeFieldInfo( $m );


        $a = $doc->toArray();

        $this->assertEquals('message', $a['message']);
        $this->assertEquals('EN_US', $a['locale']);
        $this->assertEquals(3, $a['daysUntilSigningDeadline']);
        $this->assertEquals('http://hardbears.com', $a['callbackinfo']);
        $this->assertEquals('ESIGN', $a['signatureType']);
        $this->assertEquals('SENDER_SIGNS_LAST', $a['signatureFlow']);
        $this->assertEquals('joe', $a['name']);
        $this->assertEquals('cc@test.com', $a['ccs'][0]);
        $this->assertEquals(1, count($a['ccs']));

        $this->assertEquals(2, count($a['recipients']));
        $this->assertEquals('test@test.com', $a['recipients'][0]['email']);

        $this->assertTrue( $a['securityOptions']['passwordProtection']);

        $this->assertEquals('1234abcd', $a['fileInfos'][0]['libraryDocumentId']);
        $this->assertEquals('first_name', $a['mergeFieldInfo'][0]['fieldName']);
    }
}