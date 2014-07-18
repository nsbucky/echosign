<?php namespace Echosign\Responses;

class WidgetCreationResponse {

    public $javascript;
    public $widgetId;
    public $url;

    public function __construct( array $response )
    {
        $this->javascript = \Echosign\array_get( $response, 'javascript' );
        $this->url        = \Echosign\array_get( $response, 'url' );
        $this->widgetId   = \Echosign\array_get( $response, 'widgetId' );
    }

    /**
     * @return mixed
     */
    public function getJavascript()
    {
        return $this->javascript;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getWidgetId()
    {
        return $this->widgetId;
    }


}