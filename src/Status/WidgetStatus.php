<?php namespace Echosign\Status;

class WidgetStatus {

    protected $status;

    protected $statusMessages = [
        'ABORTED'=> 'The signature workflow has been cancelled by either the sender or the recipient. This is a terminal state',
        'ENABLED'=> 'The widget is enabled',
        'OTHER'=>'For future use',
        'DISABLED'=>'The widget is disabled'
    ];

    /**
     * @param $status
     * @throws \InvalidArgumentException
     */
    public function __construct( $status )
    {
        if( ! array_key_exists($status, $this->statusMessages) ) {
            throw new \InvalidArgumentException("Invalid status set for ". __CLASS__);
        }
        $this->status = $status;
    }

    public function getMessage()
    {
        return $this->statusMessages[ $this->status ];
    }

    public function getStatus()
    {
        return $this->status;
    }
}