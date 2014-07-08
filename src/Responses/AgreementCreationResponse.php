<?php namespace Echosign\Responses;

class AgreementCreationResponse {

    protected $expiration;
    protected $agreementId;
    protected $embeddedCode;
    protected $url;

    public function __construct( array $response )
    {
        foreach( ['agreementId','embeddedCode','url'] as $k  ) {
            $this->$k = \Echosign\array_get($response, $k);
        }

        if( isset( $response['expiration'] ) ) {
            $this->expiration = \DateTime::createFromFormat( \DateTime::W3C, $response['expiration'] );
        }
    }

    /**
     * @return string
     */
    public function getAgreementId()
    {
        return $this->agreementId;
    }

    /**
     * @return string
     */
    public function getEmbeddedCode()
    {
        return $this->embeddedCode;
    }

    /**
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

}