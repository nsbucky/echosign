<?php namespace Echosign\Info;

class DeviceLocation {
    protected  $longitude, $latitude;

    public function __construct( array $config )
    {
        if( isset($config['latitude']) ) $this->latitude = $config['latitude'];
        if( isset($config['longitude']) ) $this->latitude = $config['longitude'];
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
}