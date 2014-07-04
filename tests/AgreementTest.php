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
            "expiration"=> "2014-07-04T08:17:50.212-07:00",
            "agreementId"=> "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
            "url"=> "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
        ];

        $transport = m::mock('Echosign\Transports\Guzzle');
        $transport->shouldReceive('post')->andReturn($return);

        $agreement = new \Echosign\Agreement($this->token);
        $agreement->setTransport($transport);

        $docInfo = new \Echosign\Info\DocumentCreationInfo('123456abc', 'test','SIGNER','nsbucky@gmail.com');

        $response = $agreement->create($docInfo);

        foreach( $return as $k => $v ) {
            $this->assertEquals( $v, $response->$k);
        }
    }

}