<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class WidgetPersonalizationInfo implements InfoInterface {

    protected $expiration;
    public $email;
    public $reusable;
    public $allowManualVerification;
    public $comment;

    public function __construct( $allowManualVerification, $comment, $email, $reusable )
    {
        $this->allowManualVerification = (bool) $allowManualVerification;
        $this->comment                 = $comment;
        $this->email                   = $email;
        $this->reusable                = $reusable;
    }

    /**
     * @param mixed $expiration
     */
    public function setExpiration( \DateTime $expiration )
    {
        $this->expiration = $expiration;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $options = [
            'email' => $this->email,
            'reusable' => $this->reusable,
            'allowManualVerification' => $this->allowManualVerification,
            'comment' => $this->comment
        ];

        if( $this->expiration instanceof \DateTime ) {
            $options['expiration'] = $this->expiration->format( \DateTime::W3C );
        }

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