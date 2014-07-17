<?php namespace Echosign\Responses;

use Echosign\Agreement;
use Echosign\Events\DocumentHistoryEvent;
use Echosign\Info\NextParticipantInfo;
use Echosign\Info\ParticipantInfo;
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
    protected $agreement;

    public function __construct( array $response, Agreement $agreement )
    {
        $this->message         = \Echosign\array_get($response,'message');
        $this->expiration      = array_key_exists( 'expiration', $response ) ? \DateTime::createFromFormat( \DateTime::W3C, $response['expiration'] ) : null;
        $this->locale          = \Echosign\array_get($response,'locale');
        $this->name            = \Echosign\array_get($response,'name');
        $this->agreementId     = \Echosign\array_get($response,'agreementId');
        $this->latestVersionId = \Echosign\array_get($response,'latestVersionId');

        if( array_key_exists('securityOptions', $response) ) {
            foreach( $response['securityOptions'] as $option ) {
                $doc = new DocSecurityOption($option);
                $this->securityOptions[] = $doc;
            }
        }

        $this->status = new AgreementStatus( $response['status'] );

        foreach( $response['events'] as $event ) {
            $this->events[] = new DocumentHistoryEvent( $event );
        }

        foreach( $response['nextParticipantInfos'] as $npi ) {
            $this->nextParticipantInfos[] = new NextParticipantInfo( $npi );
        }

        foreach( $response['participants'] as $p ) {
            $this->participants[] = new ParticipantInfo( $p );
        }

        $this->agreement = $agreement;
    }

    /**
     * @return array|ParticipantInfo[]
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @return array|NextParticipantInfo[]
     */
    public function getNextParticipants()
    {
        return $this->nextParticipantInfos;
    }

    /**
     * @return array|DocumentHistoryEvent[]
     */
    public function getDocumentHistoryEvents()
    {
        return $this->events;
    }

    /**
     * @return array|DocSecurityOption[]
     */
    public function getSecurityOptions()
    {
        return $this->securityOptions;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status->getStatus();
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->status->getMessage();
    }

    /**
     * @return AgreementStatus
     */
    public function getAgreementStatus()
    {
        return $this->status;
    }

    public function getId()
    {
        return $this->agreementId;
    }

    /**
     * @param Agreement $agreement
     */
    public function setAgreement( Agreement $agreement )
    {
        $this->agreement = $agreement;
    }

    /**
     * @return \Echosign\AgreementDocuments|\Echosign\Error
     */
    public function getDocuments()
    {
        return $this->agreement->documents( $this->agreementId );
    }

    /**
     * saves audit trail to tmp dir on success. you can move the file later.
     * @return string path to file
     */
    public function downloadAuditTrail()
    {
        return $this->agreement->auditTrail( $this->agreementId );
    }

}