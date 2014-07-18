<?php namespace Echosign\Responses;

class WidgetPersonalizeResponse {

    public $javascript;
    public $widgetId;
    public $url;

    function __construct( array $response )
    {
        $this->javascript = \Echosign\array_get( $response, 'javascript' );
        $this->url        = \Echosign\array_get( $response, 'url' );
        $this->widgetId   = \Echosign\array_get( $response, 'widgetId' );
    }
}