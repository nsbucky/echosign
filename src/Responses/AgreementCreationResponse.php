<?php namespace Echosign\Responses;

class AgreementCreationResponse {

    protected $expiration;
    protected $agreementId;
    protected $embeddedCode;
    protected $url;

    public function __construct( array $response )
    {
        foreach( $response as $key => $value ) {
            if( property_exists( $this, $key )) {
                $this->$key = $value;
            }
        }
    }

    public function __get( $key )
    {
        if( isset($this->$key) ) return $this->$key;
    }

}