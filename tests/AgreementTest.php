<?php

use Mockery as m;

class AgreementTest extends PHPUnit_Framework_TestCase {

    public $config;
    public $token;

    public function __construct()
    {
        $this->config = require_once __DIR__. '/../echosign-auth.php';
        $this->token = m::mock('Echosign\Token');
        $this->token->shouldReceive('getAccessToken')->andReturn('12345abc');

    }

    public function testCreate()
    {
        $return = [
            "embeddedCode"=> "<script type='text/javascript' language='JavaScript' src='https://secure.echosign.com/embed/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*&noChrome=true'></script>",
            "expiration"=> "2014-07-07T08:39:24-07:00",
            "agreementId"=> "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
            "url"=> "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
        ];

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('post')->andReturn($return);

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $fileInfos = new \Echosign\Info\FileInfo();
        $fileInfos->setDocumentURL('test.pdf','http://www.yahoo.com','application/pdf');
        $docInfo = new \Echosign\Info\DocumentCreationInfo( $fileInfos, 'test', 'recipient@gmail.com', \Echosign\Info\DocumentCreationInfo::SIGN_ESIGN, \Echosign\Info\DocumentCreationInfo::FLOW_NOT_REQUIRED );
        $interActiveOptions = new Echosign\Options\InteractiveOptions();
        /**
         * if this is not set to true YOU WILL NOT GET BACK A SIGNING URL OR EMBEDDED CODE. OMFG.
         */
        $interActiveOptions->autoLoginUser = true;
        $response = $agreement->create($docInfo, $interActiveOptions);
        $this->assertInstanceOf('Echosign\Responses\AgreementCreationResponse', $response);
        $this->assertEquals($return['embeddedCode'], $response->getEmbeddedCode());
        $this->assertInstanceOf('\DateTime',$response->getExpiration());
        $this->assertEquals($return['agreementId'], $response->getAgreementId());
        $this->assertEquals($return['url'], $response->getUrl());
    }

    public function testGetAll()
    {
        $returnJson = '{
              "userAgreementList": [
                {
                  "displayDate": "2014-07-07T08:39:24-07:00",
                  "displayUserInfo": {
                    "fullNameOrEmail": "recipient@gmail.com"
                  },
                  "esign": true,
                  "agreementId": "2AAABLblqZhCU0Zea2YWCvcXJFU6qsNOGG83nofmmdNsjVIfJEJ_mqJArenO9-WtZMxoHbueS9mk*",
                  "latestVersionId": "2AAABLblqZhBRyo_vwhJWPKtajf1t0onWqB3hYhwMwvS9a4yo5yVevqo2yHrKmg7fo6dkdItE3DA*",
                  "name": "[DEMO USE ONLY] Sign Up Proposal",
                  "status": "OUT_FOR_SIGNATURE"
                },
                {
                  "displayDate": "2014-07-04T07:17:50-07:00",
                  "displayUserInfo": {
                    "fullNameOrEmail": "recipient@gmail.com"
                  },
                  "esign": true,
                  "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
                  "latestVersionId": "2AAABLblqZhDIxXlCh5Wt1rdQsVBRUcn6BZ__P8I7oCP97ywr7RDStz8eWMZyRg9woOR9Y2-r-Cs*",
                  "name": "[DEMO USE ONLY] sample agreement",
                  "status": "OUT_FOR_SIGNATURE"
                },
                {
                  "displayDate": "2014-07-01T10:53:42-07:00",
                  "displayUserInfo": {
                    "fullNameOrEmail": "Kenrick Buchanan"
                  },
                  "esign": true,
                  "agreementId": "2AAABLblqZhBE_aupHWhvJhhJIR4i23NdT8msTyCCLN66tBGQgDROlS4No5lYSxT1cvVaOmX-FBY*",
                  "latestVersionId": "2AAABLblqZhADqAJv5FerYW4hm9_ADqDgo39oz2svWeHyvor-4G7lMaDzp61LBX4vHzcpKiC1cJY*",
                  "name": "[DEMO USE ONLY] Sign Up Proposal",
                  "status": "SIGNED"
                },
                {
                  "displayDate": "2013-03-07T10:47:43-08:00",
                  "displayUserInfo": {
                    "company": "EchoSign",
                    "fullNameOrEmail": "Customer Support"
                  },
                  "esign": false,
                  "agreementId": "2AAABLblqZhCIGg8N4914eMboUieB0LM8JEVcD2V3WzrTP-CLObxLncrbpLKcrgOkg7lWJJ5am50*",
                  "latestVersionId": "2AAABLblqZhAfzq7z35RUh-UGf8_6c-zbQfvrRulwIcKcMPqWwSp78I1OYOjab4zGR-SxAvuLE2c*",
                  "name": "Welcome to EchoSign!",
                  "status": "SIGNED"
                }
              ]
            }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( json_decode( $returnJson, true) );

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $userAgreements = $agreement->getAll();

        $this->assertInstanceOf('Echosign\Responses\UserAgreements', $userAgreements);

        $agreements = $userAgreements->getAgreements();

        $this->assertEquals(4, count( $agreements ));

        // first agreement
        $firstAgreement = $agreements[0];
        $this->assertInstanceOf('DateTime', $firstAgreement->getDisplayDate() );
        $this->assertTrue( $firstAgreement->esign );
        $this->assertEquals("[DEMO USE ONLY] Sign Up Proposal", $firstAgreement->name);
        $this->assertEquals("2AAABLblqZhCU0Zea2YWCvcXJFU6qsNOGG83nofmmdNsjVIfJEJ_mqJArenO9-WtZMxoHbueS9mk*", $firstAgreement->agreementId);
        $this->assertEquals("2AAABLblqZhBRyo_vwhJWPKtajf1t0onWqB3hYhwMwvS9a4yo5yVevqo2yHrKmg7fo6dkdItE3DA*", $firstAgreement->latestVersionId);
        $this->assertEquals("OUT_FOR_SIGNATURE", $firstAgreement->getStatus());
        $this->assertEquals("It is another user's turn to sign the document", $firstAgreement->getStatusMessage());
        $this->assertEquals("recipient@gmail.com", $firstAgreement->getUserName());
    }

    public function testGetOne()
    {
        $returnJson = '{
          "events": [
            {
              "actingUserEmail": "test@test.com",
              "actingUserIpAddress": "192.168.1.1",
              "date": "2014-07-07T08:39:24-07:00",
              "description": "Document created by Kenrick Buchanan",
              "participantEmail": "test@test.com",
              "type": "CREATED",
              "versionId": "2AAABLblqZhAAdfp0sUOyP1LUeq8K3WeWS_FHKZufymxkEuGvXgtdJT3pXhNvazcGnwa10N1o8gY*"
            },
            {
              "actingUserEmail": "test@test.com",
              "date": "2014-07-07T08:39:27-07:00",
              "description": "Sent out for signature to recipient@gmail.com",
              "participantEmail": "recipient@gmail.com",
              "type": "SIGNATURE_REQUESTED"
            }
          ],
          "latestVersionId": "2AAABLblqZhBRyo_vwhJWPKtajf1t0onWqB3hYhwMwvS9a4yo5yVevqo2yHrKmg7fo6dkdItE3DA*",
          "locale": "en_US",
          "message": "Please sign this test document.",
          "name": "[DEMO USE ONLY] Sign Up Proposal",
          "participants": [
            {
              "email": "recipient@gmail.com",
              "name": "",
              "roles": [
                "SIGNER"
              ],
              "status": "WAITING_FOR_MY_SIGNATURE"
            },
            {
              "company": "Specific Performance, LLC",
              "email": "test@test.com",
              "name": "Kenrick Buchanan",
              "roles": [
                "SENDER"
              ],
              "status": "OUT_FOR_SIGNATURE",
              "title": "IT"
            }
          ],
          "status": "OUT_FOR_SIGNATURE",
          "agreementId": "2AAABLblqZhCU0Zea2YWCvcXJFU6qsNOGG83nofmmdNsjVIfJEJ_mqJArenO9-WtZMxoHbueS9mk*",
          "nextParticipantInfos": [
            {
              "email": "recipient@gmail.com",
              "name": "",
              "waitingSince": "2014-07-07T08:39:24-07:00"
            }
          ]
        }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( json_decode( $returnJson, true) );

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $single = $agreement->get('doesntmatter');

        $this->assertInstanceOf('Echosign\Responses\AgreementInfo', $single);

        $this->assertEquals(2, count($single->getDocumentHistoryEvents()));
        $this->assertEquals(2, count($single->getParticipants()));
        $this->assertEquals(1, count($single->getNextParticipants()));

        $events = $single->getDocumentHistoryEvents();
        $firstEvent = $events[0];

        $this->assertEquals("test@test.com", $firstEvent->actingUserEmail);
        $this->assertEquals("192.168.1.1", $firstEvent->actingUserIpAddress);
        $this->assertInstanceOf('DateTime', $firstEvent->getDate());
        $this->assertEquals("Document created by Kenrick Buchanan", $firstEvent->description);
        $this->assertEquals("test@test.com", $firstEvent->participantEmail);
        $this->assertInstanceOf('Echosign\Types\AgreementEventType', $firstEvent->getAgreementEventType());
        $this->assertEquals("CREATED", $firstEvent->getAgreementEventType()->getStatus());
        $this->assertEquals("2AAABLblqZhAAdfp0sUOyP1LUeq8K3WeWS_FHKZufymxkEuGvXgtdJT3pXhNvazcGnwa10N1o8gY*", $firstEvent->versionId);

    }
    
    public function testGetDocuments()
    {
        $returnJson = '{
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

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $documents = $agreement->documents('doesntmatter');

        $this->assertInstanceOf('Echosign\Responses\AgreementDocuments', $documents);
        $this->assertEquals(1, count($documents->getDocuments()));
        $this->assertEquals(0, count($documents->getSupportingDocuments()));
        $allDocs = $documents->getDocuments();
        $firstDocument = $allDocs[0];

        $this->assertEquals("2AAABLblqZhBEsJow3IswASHPCt74o33MTcMKvaqnH1sbZEyh18WYqB8DoKkUrlemBsVyIhuSOhI*", $firstDocument->getId());
        $this->assertEquals("application/pdf", $firstDocument->getMimeType());
        $this->assertEquals("May 5.pdf", $firstDocument->getName());
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

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $documentPath = $agreement->document('balls', $documentId, $file);
        $this->assertTrue( is_readable($file));

        $this->assertEquals($file, $documentPath);
    }

    public function testGetAuditTrail()
    {
        $agreementId = '2AAABLblqZhBEsJF';
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $agreementId.'.pdf';
        $fp = fopen( $file, 'w+');
        fwrite($fp, "suck my dick im a sharks nuts");
        fclose($fp);

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( $file );

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $documentPath = $agreement->auditTrail($agreementId, $file);
        $this->assertTrue( is_readable($file));

        $this->assertEquals($file, $documentPath);
    }

    public function testGetSigningUrls()
    {
        $returnJson = '{
              "signingUrls": [
                {
                  "email": "nsbucky@gmail.com",
                  "esignUrl": "https://secure.echosign.com/public/apiesign?spm=ZlRy5JswjlWd8QXO4EvgJw**.cGlkPTE3MzY4Mzc0NDE*",
                  "simpleEsignUrl": "https://secure.echosign.com/public/apiesign?spm=8W3gTaXB3omaJUNwQKBxkQ**.c2ltcGxlPXRydWUmcGlkPTE3MzY4Mzc0NDE*"
                }
              ]
            }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( json_decode( $returnJson, true) );

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $urls = $agreement->signingUrls('balls');

        $this->assertInstanceOf('Echosign\Responses\SigningUrls', $urls);

        $allUrls = $urls->getUrls();
        $firstUrl = $allUrls[0];

        $this->assertEquals("nsbucky@gmail.com", $firstUrl->email);
        $this->assertEquals("https://secure.echosign.com/public/apiesign?spm=ZlRy5JswjlWd8QXO4EvgJw**.cGlkPTE3MzY4Mzc0NDE*", $firstUrl->esignUrl);
        $this->assertEquals("https://secure.echosign.com/public/apiesign?spm=8W3gTaXB3omaJUNwQKBxkQ**.c2ltcGxlPXRydWUmcGlkPTE3MzY4Mzc0NDE*", $firstUrl->simpleEsignUrl);
    }

    public function testGetCombinedDocument()
    {
        $agreementId = '2AAABLblqZhBEsJC';
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $agreementId.'.pdf';
        $fp = fopen( $file, 'w+');
        fwrite($fp, "suck my dick im a sharks nuts scrotum");
        fclose($fp);

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('get')->andReturn( $file );

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $documentPath = $agreement->combinedDocument($agreementId, $file);
        $this->assertTrue( is_readable($file));

        $this->assertEquals($file, $documentPath);
    }

    public function testUpdateStatus()
    {
        $returnJson = '{
          "result": "CANCELLED"
        }';

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('put')->andReturn( json_decode( $returnJson, true) );

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $result = $agreement->cancel('balls');

        $this->assertInstanceOf('Echosign\Responses\AgreementStatusUpdateResponse', $result);

        $this->assertEquals('CANCELLED', $result->result);

    }

}