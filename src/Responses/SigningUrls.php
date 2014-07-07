<?php namespace Echosign\Responses;

use Echosign\Info\SigningUrl;

class SigningUrls {

    protected $signingUrls = [];

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        foreach( $response['signingUrls'] as $url ) {
            $this->signingUrls[] = new SigningUrl($url['email'], $url['simpleEsignUrl'], $url['esignUrl']);
        }
    }

    /**
     * @return array|SigningUrl[]
     */
    public function getUrls()
    {
        return $this->signingUrls;
    }
}