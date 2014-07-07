<?php namespace Echosign\Responses;

class AgreementStatusUpdateResponse {

    public $result;

    public function __construct( array $response )
    {
        $this->result = $response['result'];
    }

}