<?php namespace Echosign\Info;

use Echosign\Options\LibDocParticipantInfoSecurityOption;
use Echosign\Roles\LibDocParticipantRole;
use Echosign\Status\UserLibDocumentStatus;

class LibDocParticipantInfo {

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
                $this->securityOptions[] = new LibDocParticipantInfoSecurityOption( $o );
            }
        }

        if( array_key_exists('roles', $config )) {
            foreach( $config['roles'] as $r ) {
                $this->roles[] = new LibDocParticipantRole( $r );
            }
        }

        if( array_key_exists('alternateParticipants', $config )) {
            foreach( $config['alternateParticipants'] as $p ) {
                $this->alternateParticipants[] = new LibDocParticipantInfo( $config['alternateParticipants'] );
            }
        }

        $this->status = new UserLibDocumentStatus( $config['status'] );
    }

    /**
     * @return array|LibDocParticipantRole[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return array|LibDocParticipantInfoSecurityOption[]
     */
    public function getSecurityOptions()
    {
        return $this->securityOptions;
    }

    /**
     * @return array|LibDocParticipantInfo[]
     */
    public function getAlternateParticipants()
    {
        return $this->alternateParticipants;
    }

    /**
     * @return \Echosign\Status\UserLibDocumentStatus
     */
    public function getStatus()
    {
        return $this->status;
    }


}