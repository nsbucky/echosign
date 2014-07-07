<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class AgreementStatusUpdateInfo implements InfoInterface {

    const CANCEL = 'cancel';

    protected $comment;

    protected $notifySigner = false;

    public function __construct( $comment=null, $notifySigner=false )
    {
        $this->comment = $comment;
        $this->notifySigner = (bool) $notifySigner;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'value'        => self::CANCEL,
            'comment'      => $this->comment,
            'notifySigner' => $this->notifySigner
        ];
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}