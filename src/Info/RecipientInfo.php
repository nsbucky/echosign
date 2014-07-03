<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class RecipientInfo implements InfoInterface {

    public $fax;
    public $email;
    public $role;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'fax'   => $this->fax,
            'email' => $this->email,
            'role'  => $this->role
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