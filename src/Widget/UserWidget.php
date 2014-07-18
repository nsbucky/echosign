<?php namespace Echosign\Widget;

use Echosign\Status\WidgetStatus;

class UserWidget {

    public $javascript;
    protected $status;
    public $name;
    public $widgetId;
    public $url;
    protected $modifiedDate;

    function __construct( $javascript, $modifiedDate, $name, $status, $url, $widgetId )
    {
        $this->javascript   = $javascript;
        $this->setModifiedDate( $modifiedDate );
        $this->name         = $name;
        $this->setStatus( $status );
        $this->url          = $url;
        $this->widgetId     = $widgetId;
    }


    /**
     * @param mixed $status
     */
    public function setStatus( $status )
    {
        $this->status = new WidgetStatus( $status );
    }

    /**
     * @param mixed $modifiedDate
     */
    public function setModifiedDate( $modifiedDate )
    {
        $this->modifiedDate = \DateTime::createFromFormat( \DateTime::W3C, $modifiedDate);
    }


}