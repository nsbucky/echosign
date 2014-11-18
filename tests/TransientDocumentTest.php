<?php

use Mockery as m;

class TransientDocumentTest extends PHPUnit_Framework_TestCase {

    public $config;
    public $token;

    public function __construct()
    {
        $this->token = m::mock('Echosign\Token');
        $this->token->shouldReceive('getAccessToken')->andReturn('12345abc');
    }

    public function testConstruct()
    {
        $doc = new \Echosign\TransientDocument($this->token, '/path/to/file/balls.pdf', 'application/pdf');

        $this->assertEquals('balls.pdf', $doc->getFileName());
        $this->assertEquals('application/pdf', $doc->getMimeType());
    }

    public function testSend()
    {
        // create a dummy file
        $file = tempnam(sys_get_temp_dir(), 'TMP');
        $fp = fopen( $file, 'w+');
        fwrite($fp, "suck my dick im a shark");
        fclose($fp);

        $doc = new \Echosign\TransientDocument( $this->token, $file );

        $request = m::mock('Echosign\Transports\Guzzle');
        $request->shouldReceive('post')->andReturn([
            'transientDocumentId'=>'12345abc',
        ]);

        $doc->setTransport($request);

        $this->assertInstanceOf('Echosign\Responses\TransientDocuments',$doc->send());

        $this->assertEquals('12345abc', $doc->getDocumentId());
    }
}