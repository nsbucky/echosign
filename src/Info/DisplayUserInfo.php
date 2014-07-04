<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class DisplayUserInfo implements InfoInterface {

    public $company;
    public $fullNameOrEmail;

    public function __construct( array $config )
    {
        foreach( $config as $key => $value ) {
            if( property_exists( $this, $key )) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'company'         => $this->company,
            'fullNameOrEmail' => $this->fullNameOrEmail,
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