<?php

use Mockery as m;

class LibraryDocumentTest extends PHPUnit_Framework_TestCase {

    public $config;
    public $token;

    public function __construct()
    {
        $this->config = require_once __DIR__. '/../echosign-auth.php';
        $this->token = m::mock('Echosign\Token');
        $this->token->shouldReceive('getAccessToken')->andReturn('12345abc');
    }

    public function testGet()
    {
        $returnJson = '{
          "libraryDocumentList": [
            {
              "libraryDocumentId": "2AAABLblqZhA9E8BC0pVAoJVrk8UxJ6siAWGZ-WMcarup6ASLBD7XfRIM0SoNt0YAeghVtBsPMKs*",
              "libraryTemplateTypes": [
                "DOCUMENT"
              ],
              "modifiedDate": "2014-01-09T13:06:31-08:00",
              "name": "W-4 (IRS Employee Withholding Allowance) 2014",
              "scope": "GLOBAL"
            },
            {
              "libraryDocumentId": "2AAABLblqZhAhIDGCsIk8HSPqeIR5Q0AMFedt7855UZDcRFp-ZT4AFNTEjS_jgVT9-dvDcMPML94*",
              "libraryTemplateTypes": [
                "DOCUMENT"
              ],
              "modifiedDate": "2013-12-10T14:42:55-08:00",
              "name": "I-9 (Employment Eligibility Verification)",
              "scope": "GLOBAL"
            },
            {
              "libraryDocumentId": "2AAABLblqZhDboCBhA_Eb14jdtyXMorUzFSPEQhGSCWF0ddDwNzllBJb-o9R49AJ5zmmhQSNwdRQ*",
              "libraryTemplateTypes": [
                "DOCUMENT"
              ],
              "modifiedDate": "2013-12-10T14:42:55-08:00",
              "name": "W-9 (Request for Taxpayer Identification Number) ",
              "scope": "GLOBAL"
            }
          ]
        }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( json_decode( $returnJson, true) );

        $lb = new \Echosign\LibraryDocument($this->token);
        $lb->setTransport($transport);

        $docList = $lb->getAll();

        $this->assertInstanceOf('Echosign\Responses\DocumentLibraryItems', $docList);

        $allDocs = $docList->getLibraryDocuments();

        $firstDoc = $allDocs[0];

        $this->assertEquals("2AAABLblqZhA9E8BC0pVAoJVrk8UxJ6siAWGZ-WMcarup6ASLBD7XfRIM0SoNt0YAeghVtBsPMKs*", $firstDoc->getLibraryDocumentId());
        $this->assertInstanceOf('\DateTime', $firstDoc->getModifiedDate());
        $this->assertEquals("W-4 (IRS Employee Withholding Allowance) 2014", $firstDoc->getName());
        $this->assertEquals("GLOBAL", $firstDoc->getScope()->getScope());

    }

    public function testGetDocumentInfo()
    {
        $returnJson = '{
              "events": [
                {
                  "actingUserEmail": "forms@echosign.com",
                  "actingUserIpAddress": "192.150.10.206",
                  "date": "2014-01-09T12:41:16-08:00",
                  "description": "Document created by EchoSign Forms",
                  "participantEmail": "forms@echosign.com",
                  "type": "CREATED",
                  "versionId": "2AAABLblqZhDvRyNu367iWzb3JJyEY1--Rdz2_H6DvHeijcyfMQEitLde70FZ9kIdujFB2lYT1Vw*"
                }
              ],
              "latestVersionId": "2AAABLblqZhAh9VYV4--u7g4RBaRXeKCf8FAAld9skyGchGfBo11hJUWxq5CWR67q6J34unJ0MYc*",
              "locale": "en_US",
              "name": "W-4 (IRS Employee Withholding Allowance) 2014",
              "participants": [
                {
                  "company": "EchoSign Forms",
                  "email": "forms@echosign.com",
                  "name": "EchoSign Forms",
                  "roles": [
                    "SENDER"
                  ],
                  "status": "FORM"
                }
              ],
              "securityOptions":[
                "OTHER"
              ],
              "status": "DOCUMENT_LIBRARY",
              "libraryDocumentId": "2AAABLblqZhA9E8BC0pVAoJVrk8UxJ6siAWGZ-WMcarup6ASLBD7XfRIM0SoNt0YAeghVtBsPMKs*"
            }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( json_decode( $returnJson, true) );

        $lb = new \Echosign\LibraryDocument($this->token);
        $lb->setTransport($transport);

        $docInfo = $lb->getInfo( 'doesntmatter' );
        $this->assertInstanceOf('Echosign\Responses\LibraryDocumentInfo', $docInfo);

        $this->assertEquals("2AAABLblqZhAh9VYV4--u7g4RBaRXeKCf8FAAld9skyGchGfBo11hJUWxq5CWR67q6J34unJ0MYc*", $docInfo->latestVersionId);
        $this->assertEquals("en_US",$docInfo->locale);
        $this->assertEquals("W-4 (IRS Employee Withholding Allowance) 2014", $docInfo->name);
        $this->assertEquals("2AAABLblqZhA9E8BC0pVAoJVrk8UxJ6siAWGZ-WMcarup6ASLBD7XfRIM0SoNt0YAeghVtBsPMKs*", $docInfo->libraryDocumentId);
        $this->assertEquals("DOCUMENT_LIBRARY", $docInfo->getStatus()->getStatus());

        $events = $docInfo->getEvents();
        $this->assertEquals("forms@echosign.com", $events[0]->actingUserEmail);
        $this->assertEquals("192.150.10.206", $events[0]->actingUserIpAddress);
        $this->assertInstanceOf("DateTime", $events[0]->date);
        $this->assertEquals("forms@echosign.com", $events[0]->participantEmail);
        $this->assertEquals("CREATED", $events[0]->getType()->getType());
        $this->assertEquals("2AAABLblqZhDvRyNu367iWzb3JJyEY1--Rdz2_H6DvHeijcyfMQEitLde70FZ9kIdujFB2lYT1Vw*", $events[0]->versionId);

        $participants = $docInfo->getParticipants();
        $this->assertEquals("EchoSign Forms", $participants[0]->company);
        $this->assertEquals("forms@echosign.com", $participants[0]->email);
        $this->assertEquals("EchoSign Forms", $participants[0]->name);
        $this->assertTrue($participants[0]->getRoles()[0]->isSender());
        $this->assertEquals("FORM",$participants[0]->getStatus()->getStatus());

        $secops = $docInfo->getSecurityOptions();
        $this->assertEquals("OTHER", $secops[0]->getOption());
    }

    public function testGetDocuments()
    {
        $returnJson = '{
           "supportingDocuments": [
            {
              "supportingDocumentId": "2AAABLblqZhBEsJow3IswASHPCt74o33MTcMKvaqnH1sbZEyh18WYqB8DoKkUrlemBsVyIhuSOhI*",
              "mimeType": "application/pdf",
              "displayLabel": "May 5.pdf",
              "fieldname" : "first_name"
            }
          ],
          "documents": [
            {
              "documentId": "2AAABLblqZhBEsJow3IswASHPCt74o33MTcMKvaqnH1sbZEyh18WYqB8DoKkUrlemBsVyIhuSOhI*",
              "mimeType": "application/pdf",
              "name": "May 5.pdf"
            }
          ]
        }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( json_decode( $returnJson, true) );

        $lb = new \Echosign\LibraryDocument($this->token);
        $lb->setTransport($transport);

        $documents = $lb->documents('doesntmatter');

        $this->assertInstanceOf('Echosign\Responses\Documents', $documents);

        $supdocs = $documents->getSupportingDocuments();
        $this->assertEquals("2AAABLblqZhBEsJow3IswASHPCt74o33MTcMKvaqnH1sbZEyh18WYqB8DoKkUrlemBsVyIhuSOhI*", $supdocs[0]->getId());
        $this->assertEquals("application/pdf", $supdocs[0]->getMimeType());
        $this->assertEquals("May 5.pdf", $supdocs[0]->getDisplayLabel());
        $this->assertEquals("first_name", $supdocs[0]->getFieldName());

        $odoc = $documents->getDocuments();
        $this->assertEquals("2AAABLblqZhBEsJow3IswASHPCt74o33MTcMKvaqnH1sbZEyh18WYqB8DoKkUrlemBsVyIhuSOhI*", $odoc[0]->getId());
        $this->assertEquals("application/pdf", $odoc[0]->getMimeType());
        $this->assertEquals("May 5.pdf", $odoc[0]->getName());
    }

    public function testGetDocument()
    {
        $documentId = '2AAABLblqZhBEsJo';
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId;
        $fp = fopen( $file, 'w+');
        fwrite($fp, "suck my dick im a shark");
        fclose($fp);

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( $file );

        $agreement = new \Echosign\LibraryDocument($this->token);
        $agreement->setTransport($transport);

        $documentPath = $agreement->document('balls', $documentId, $file);
        $this->assertTrue( is_readable($file));

        $this->assertEquals($file, $documentPath);
    }

    public function testGetAuditTrail()
    {
        $documentId = '2AAABLblqZhBEsJF';
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId.'.pdf';
        $fp = fopen( $file, 'w+');
        fwrite($fp, "suck my dick im a sharks nuts");
        fclose($fp);

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( $file );

        $doc = new \Echosign\LibraryDocument($this->token);
        $doc->setTransport($transport);

        $documentPath = $doc->auditTrail($documentId, $file);
        $this->assertTrue( is_readable($file));

        $this->assertEquals($file, $documentPath);
    }

    public function testGetCombinedDocument()
    {
        $documentId = '2AAABLblqZhBEsJC';
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId.'.pdf';
        $fp = fopen( $file, 'w+');
        fwrite($fp, "suck my dick im a sharks nuts scrotum");
        fclose($fp);

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( $file );

        $doc = new \Echosign\LibraryDocument($this->token);
        $doc->setTransport($transport);

        $documentPath = $doc->combinedDocument($documentId, $file);
        $this->assertTrue( is_readable($file));

        $this->assertEquals($file, $documentPath);
    }
}