<?php namespace Echosign\Responses;

use Echosign\Documents\WidgetOriginalDocument;

class WidgetDocuments {

    protected $documents = [];

    public function __construct( array $response )
    {
        foreach( $response['WidgetOriginalDocument'] as $d ) {
            $this->documents[] = new WidgetOriginalDocument($d, $this);
        }
    }
}