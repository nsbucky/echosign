<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class RecipientInfo implements InfoInterface {

    public $fax;
    public $email;
    public $role;

    public function __construct($email=null, $fax=null, $role=null)
    {
        $this->email = filter_var( $email, FILTER_SANITIZE_EMAIL );
        $this->fax   = filter_var( $fax, FILTER_SANITIZE_NUMBER_INT );
        if( ! in_array($role, ['SIGNER','APPROVER']) ) {
            $role = null;
        }
        $this->role = $role;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'fax'   => $this->fax,
            'email' => $this->email,
            'role'  => $this->role
        ]);
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}