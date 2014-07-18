<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class CounterSignerInfo implements InfoInterface {

    public $email;
    protected $role;
    protected $securityOptions = [];

    /**
     * @param mixed $securityOptions
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