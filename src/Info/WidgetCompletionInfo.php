<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class WidgetCompletionInfo implements InfoInterface {

    public $deframe = false;
    public $delay = 0;
    public $url;

    public function __construct( $deframe, $delay, $url )
    {
        $this->deframe = (bool) $deframe;
        $this->delay   = $delay;
        $this->url     = $url;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter( [
            'deframe' => $this->deframe,
            'delay'   => $this->delay,
            'url'     => $this->url
        ] );
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


    /**
     * @param boolean $deframe
     */
    public function setDeframe( $deframe )
    {
        $this->deframe = $deframe;
    }

    /**
     * @return boolean
     */
    public function getDeframe()
    {
        return $this->deframe;
    }

    /**
     * @param int $delay
     */
    public function setDelay( $delay )
    {
        $this->delay = $delay;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param mixed $url
     */
    public function setUrl( $url )
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }


}