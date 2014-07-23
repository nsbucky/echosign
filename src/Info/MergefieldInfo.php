<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class MergefieldInfo implements  InfoInterface {

    public $defaultValue;
    public $fieldName;

    public function __construct( $defaultValue = null, $fieldName = null )
    {
        $this->defaultValue = $defaultValue;
        $this->fieldName    = $fieldName;
    }

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