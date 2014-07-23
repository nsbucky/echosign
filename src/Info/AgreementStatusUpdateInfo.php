<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class AgreementStatusUpdateInfo implements InfoInterface {

    const CANCEL = 'cancel';

    protected $comment;

    protected $notifySigner = false;

    /**
     * @param null $comment
     * @param bool $notifySigner
     */
    public function __construct( $comment=null, $notifySigner=false )
    {
        $this->comment = $comment;
        $this->notifySigner = (bool) $notifySigner;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return boolean
     */
    public function getNotifySigner()
    {
        return $this->notifySigner;
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