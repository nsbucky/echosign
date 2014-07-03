<?php namespace Echosign\Status;

class UserDocumentStatus {
    public $EXPIRED;
    public $SIGNED;
    public $WAITINGFOR_MY_APPROVAL;
    public $OUT_FOR_SIGNATURE;
    public $ARCHIVED;
    public $APPROVED;
    public $WAITING_FOR_MY_SIGNATURE;
    public $WAITING_FOR_AUTHORING;
    public $WIDGET;
    public $OUT_FOR_APPROVAL;
    public $RECALLED;
    public $FORM;
    public $WAITING_FOR_FAXIN;

    public function __construct( array $config )
    {
        foreach( $config as $key => $value ) {
            if( property_exists( $this, $key )) {
                $this->$key = $value;
            }
        }
    }
}