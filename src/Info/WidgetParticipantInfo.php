<?php namespace Echosign\Info;

use Echosign\Options\ParticipantInfoSecurityOption;
use Echosign\Roles\ParticipantRole;

class WidgetParticipantInfo {

    public $title, $email, $company, $name;
    protected $securityOptions = [];
    protected $status;
    protected $roles = [];
    protected $alternateParticipants = [];

    /**
     * @param array $config
     */
    public function __construct( array $config )
    {
        foreach(['title','email','company','name'] as $k) {
            $this->$k = \Echosign\array_get($config, $k );
        }

        if( array_key_exists('securityOptions', $config)) {
            foreach( $config['securityOptions'] as $o ) {
                $this->securityOptions[] = new ParticipantInfoSecurityOption( $o );
            }
        }

        if( array_key_exists('roles', $config )) {
            foreach( $config['roles'] as $r ) {
                $this->roles[] = new ParticipantRole( $r );
            }
        }

        if( array_key_exists('alternateParticipants', $config )) {
            foreach( $config['alternateParticipants'] as $p ) {
                $this->alternateParticipants[] = new ParticipantInfo( $config['alternateParticipants'] );
            }
        }
    }

    /**
     * @return array|ParticipantRole[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return array|ParticipantInfoSecurityOption[]
     */
    public function getSecurityOptions()
    {
        return $this->securityOptions;
    }

    /**
     * @return array|ParticipantInfo[]
     */
    public function getAlternateParticipants()
    {
        return $this->alternateParticipants;
    }

}