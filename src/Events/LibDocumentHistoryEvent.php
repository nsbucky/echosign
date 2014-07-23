<?php namespace Echosign\Events;

use Echosign\Info\LibDocEventDeviceLocation;
use Echosign\Types\EventType;

class LibDocumentHistoryEvent {

    public $synchronizationKey, $participantEmail, $description,
           $versionId, $comment, $actingUserIpAddress, $actingUserEmail;
    protected $date;
    protected $type;
    protected $deviceLocation;

    /**
     * @param array $config
     */
    public function __construct( array $config )
    {
        $this->synchronizationKey  = \Echosign\array_get( $config, 'synchronizationKey' );
        $this->participantEmail    = \Echosign\array_get( $config, 'participantEmail' );
        $this->description         = \Echosign\array_get( $config, 'description' );
        $this->versionId           = \Echosign\array_get( $config, 'versionId' );
        $this->comment             = \Echosign\array_get( $config, 'comment' );
        $this->actingUserIpAddress = \Echosign\array_get( $config, 'actingUserIpAddress' );
        $this->actingUserEmail     = \Echosign\array_get( $config, 'actingUserEmail' );

        if( array_key_exists('date', $config )) {
            $this->date = \DateTime::createFromFormat(\DateTime::W3C, $config['date']);
        }

        if( array_key_exists('type', $config) ) {
            $this->type = new EventType($config['type']);
        }

        if( array_key_exists('deviceLocation', $config) ) {
            $this->deviceLocation = new LibDocEventDeviceLocation( $config['deviceLocation']['latitude'], $config['deviceLocation']['longitude']);
        }
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * @return EventType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return LibDocEventDeviceLocation
     */
    public function getDeviceLocation()
    {
        return $this->deviceLocation;
    }



}