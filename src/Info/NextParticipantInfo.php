<?php namespace Echosign\Info;

class NextParticipantInfo {

    protected $waitingSince;
    public $email, $name;

    public function __construct( array $config )
    {
        if( array_key_exists('waitingSince', $config )) {
            $this->waitingSince = \DateTime::createFromFormat( \DateTime::W3C, $config['waitingSince'] );
        }

        if( array_key_exists('email', $config )) {
            $this->email = $config['email'];
        }

        if( array_key_exists('name', $config )) {
            $this->name = $config['name'];
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return \DateTime
     */
    public function getWaitingSince()
    {
        return $this->waitingSince;
    }
}