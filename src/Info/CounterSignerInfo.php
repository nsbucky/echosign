<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;
use Echosign\Options\WidgetSignerSecurityOption;

class CounterSignerInfo implements InfoInterface {

    public $email;
    protected $role;
    protected $securityOptions = [];

    public function __construct( $email = null, $role = null, WidgetSignerSecurityOption $securityOptions = null )
    {
        $this->email           = $email;
        $this->role            = $role;
        $this->securityOptions[] = $securityOptions;
    }


    /**
     * @param WidgetSignerSecurityOption $securityOptions
     */
    public function setSecurityOptions( WidgetSignerSecurityOption $securityOptions )
    {
        $this->securityOptions[] = $securityOptions;
    }

    /**
     * @param mixed $role
     * @throws \InvalidArgumentException
     */
    public function setRole( $role )
    {
        if( ! in_array($role, ['SIGNER','APPROVER'])) {
            throw new \InvalidArgumentException('Invalid role specified');
        }
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }


    /**
     * @return array
     */
    public function toArray()
    {
       $options = [
           'email' => $this->email,
           'role' => $this->role,
       ];

        if( count( $this->securityOptions ) ) {
            $options['securityOptions'] = [];
            foreach( $this->securityOptions as $o ) {
                $options['securityOptions'][] = $o->toArray();
            }
        }

        return array_filter($options);
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}