<?php namespace Echosign\Responses;

class WidgetStatusUpdateResponse {

    public $message;
    public $code;

    public function __construct( array $response )
    {
        $this->message = \Echosign\array_get( $response, 'message' );
        $this->code    = \Echosign\array_get( $response, 'code');
    }
}