<?php namespace Echosign\Info;

class SigningUrl {

    public $email, $simpleEsignUrl, $esignUrl;

    public function __construct( $email=null, $simpleEsignUrl=null, $esignUrl=null )
    {
        $this->email = $email;
        $this->simpleEsignUrl = $simpleEsignUrl;
        $this->esignUrl = $esignUrl;
    }

}