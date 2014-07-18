<?php namespace Echosign\Info;

class WidgetInfo {
    public $message;
    public $javascript;
    protected $securityOptions;
    protected $status;
    protected $events = [];
    public $name;
    public $locale = 'EN_US';
    public $widgetId;
    protected $participants = [];
    public $latestVersionId;
    public $url;

    /**
     * @param array $events
     */
    public function setEvents( $events )
    {
        $this->events = $events;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param mixed $securityOptions
     */
    public function setSecurityOptions( $securityOptions )
    {
        $this->securityOptions = $securityOptions;
    }

    /**
     * @return mixed
     */
    public function getSecurityOptions()
    {
        return $this->securityOptions;
    }

    /**
     * @param mixed $status
     */
    public function setStatus( $status )
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param array $participants
     */
    public function setParticipants( $participants )
    {
        $this->participants = $participants;
    }

    /**
     * @return array
     */
    public function getParticipants()
    {
        return $this->participants;
    }


}