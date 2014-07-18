<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class WidgetStatusUpdateInfo implements InfoInterface {

    public $message;
    public $redirectUrl;
    protected $status;

    /**
     * @param $message
     * @param $redirectUrl
     * @param $status
     * @throws \InvalidArgumentException
     */
    public function __construct( $message, $redirectUrl, $status )
    {
        $this->message     = $message;
        $this->redirectUrl = $redirectUrl;

        if( ! in_array($status, ['ENABLE','DISABLE']) ) {
            throw new \InvalidArgumentException('invalid status given');
        }

        $this->status      = $status;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        $options = [
            ''
        ];
        return array_filter( $options );
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}