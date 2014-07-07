<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class DisplayUserInfo implements InfoInterface {

    public $company;
    public $fullNameOrEmail;

    public function __construct( $company, $fullNameOrEmail )
    {
        $this->company         = $company;
        $this->fullNameOrEmail = $fullNameOrEmail;
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