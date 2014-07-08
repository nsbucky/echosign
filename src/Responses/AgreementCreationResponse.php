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

    /**
     * @return mixed
     */
    public function getAgreementId()
    {
        return $this->agreementId;
    }

    /**
     * @return mixed
     */
    public function getEmbeddedCode()
    {
        return $this->embeddedCode;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

}