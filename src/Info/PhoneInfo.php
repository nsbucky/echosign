<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class PhoneInfo implements InfoInterface {

    public $phone;
    public $countryCode;

    public function __construct( $countryCode, $phone )
    {
        $this->countryCode = $countryCode;
        $this->phone       = $phone;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'phone' => $this->phone,
            'countryCode' => $this->countryCode,
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