<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class WidgetVaultingInfo implements InfoInterface {

    public $enabled;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'enabled'=>(bool) $this->enabled,
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