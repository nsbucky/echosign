<?php namespace Echosign\Events;

use Echosign\Info\DeviceLocation;
use Echosign\Types\AgreementEventType;

class DocumentHistoryEvent {

    public $synchronizationKey;
    public $participantEmail;
    public $description;
    public $versionId;
    public $comment;
    public $actingUserIpAddress;
    protected $type;
    public $date;
    public $deviceLocation;
    public $actingUserEmail;

    /**
     * @param array $config
     */
    public function __construct( array $config )
    {
        foreach(['synchronizationKey','participantEmail','description',
                'versionId','comment','actingUserIpAddress','actingUserEmail'] as $k) {
            if( ! array_key_exists( $k, $config ) ) continue;
            $this->$k = $config[ $k ];
        }

        if( array_key_exists('date', $config)) {
            $this->date = \DateTime::createFromFormat(\DateTime::W3C, $config['date']);
        }

        if( array_key_exists('deviceLocation', $config) ) {
            $this->deviceLocation = new DeviceLocation( $config['deviceLocation']['latitude'], $config['deviceLocation']['longitude'] );
        }

        if( array_key_exists('type', $config )) {
            $this->type = new AgreementEventType( $config['type'] );
        }
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        if( isset($this->comment) ) return $this->comment;
        return $this->type->getMessage();
    }

    /**
     * @return AgreementEventType
     */
    public function getAgreementEventType()
    {
        return $this->type;
    }

    /**
     * @return DeviceLocation
     */
    public function getDeviceLocation()
    {
        return $this->deviceLocation;
    }

}