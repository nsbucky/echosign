<?php namespace Echosign\Responses;

use Echosign\Events\LibDocumentHistoryEvent;
use Echosign\Info\LibDocParticipantInfo;
use Echosign\Options\LibDocSecurityOption;
use Echosign\Status\LibDocStatus;

class LibraryDocumentInfo {

    public $message;
    protected $securityOptions = [];
    protected $status;
    public $libraryDocumentId;
    protected $events = [];
    public $locale;
    public $name;
    protected $participants = [];
    public $latestVersionId;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->message           = \Echosign\array_get( $response, 'message' );
        $this->libraryDocumentId = $response['libraryDocumentId'];
        $this->locale            = $response['locale'];
        $this->name              = $response['name'];
        $this->latestVersionId   = $response['latestVersionId'];

        foreach( $response['events'] as $event ) {
            $this->events[] = new LibDocumentHistoryEvent($event);
        }

        if( array_key_exists('securityOptions', $response) ) {
            foreach( $response['securityOptions'] as $option ) {
                $this->securityOptions[] = new LibDocSecurityOption( $option );
            }
        }

        if( array_key_exists('participants', $response) ) {
            foreach( $response['participants'] as $p ) {
                $this->participants[] = new LibDocParticipantInfo($p);
            }
        }

        $this->status = new LibDocStatus( $response['status'] );

    }

    /**
     * @return array|LibDocParticipantInfo[]
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @return array|LibDocSecurityOption[]
     */
    public function getSecurityOptions()
    {
        return $this->securityOptions;
    }

    /**
     * @return \Echosign\Status\LibDocStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array|LibDocumentHistoryEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }


}