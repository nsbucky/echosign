<?php namespace Echosign\Responses;

use Echosign\Options\DocSecurityOption;
use Echosign\Status\AgreementStatus;

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
            $doc = new DocSecurityOption($option);
            $this->securityOptions = $doc;
        }

        $this->status = new AgreementStatus( $response['status'] );
    }

}