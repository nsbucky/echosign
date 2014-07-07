<?php namespace Echosign\Responses;

use Echosign\Options\DocSecurityOption;

class AgreementInfo {

    public $message;
    protected $securityOptions = [];
    public $expiration;
    protected $status;
    protected $events = [];
    public $locale;
    public $name;
    protected $nextParticipantInfos = [];
    public $agreementId;
    protected $participants = [];
    public $latestVersionId;

    public function __construct( array $response )
    {
        $this->message = $response['message'];
        $this->expiration = $response['expiration'];
        $this->locale = $response['locale'];
        $this->name = $response['name'];
        $this->agreementId = $response['agreementId'];
        $this->latestVersionId = $response['latestVersionId'];

        foreach( $response['securityOptions'] as $option ) {
            $doc = new DocSecurityOption;
            $doc->OPEN_PROTECTED = $option['OPEN_PROTECTED'];
            $doc->OTHER = $option['OTHER'];
            $this->securityOptions = $doc;
        }

        $this->status =
    }

}