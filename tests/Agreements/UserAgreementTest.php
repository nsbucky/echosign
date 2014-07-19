<?php
use Mockery as m;
use Echosign\Agreements\UserAgreement;
use Echosign\Agreement;

class UserAgreementTest extends PHPUnit_Framework_TestCase {

    public $config;
    public $token;

    public function __construct()
    {
        $this->config = require_once __DIR__. '/../../echosign-auth.php';
        $this->token = m::mock('Echosign\Token');
        $this->token->shouldReceive('getAccessToken')->andReturn('12345abc');
    }


    public function testCreate()
    {
        $displayDate = new DateTime();

        $response = [
            'displayDate' => $displayDate->format( DateTime::W3C ),
            'status'      => 'OUT_FOR_SIGNATURE',
            'name'        => 'test',
            'displayUserInfo' => ['company'=>'mycompany','fullNameOrEmail'=>'myname'],
            'agreementId' => '12345abcdef',
            'esign'       => true,
            'latestVersionId' => '1234adsf',
        ];

        $agreement = new Agreement( $this->token );
        $a = new UserAgreement( $response, $agreement );

        // make sure all the stuff gets set correctly.
        $this->assertEquals($response['displayDate'], $a->getDisplayDate()->format( DateTime::W3C ) );
        $this->assertEquals($response['status'], $a->getStatus());
        $this->assertEquals('It is another user\'s turn to sign the document', $a->getStatusMessage());
        $this->assertEquals($response['name'], $a->name);
        $this->assertEquals('mycompany', $a->getDisplayUserInfo()->company);
        $this->assertEquals('mycompany', $a->getCompany());
        $this->assertEquals('myname', $a->getDisplayUserInfo()->fullNameOrEmail);
        $this->assertEquals('myname', $a->getUserName());
        $this->assertEquals($response['agreementId'], $a->agreementId);
        $this->assertTrue($a->esign);
        $this->assertEquals($response['latestVersionId'], $a->latestVersionId);
    }
}