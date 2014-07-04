<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class MergefieldInfo implements  InfoInterface {

    public $defaultValue;
    public $fieldName;

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'defaultValue' => $this->defaultValue,
            'fieldName'    => $this->fieldName,
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