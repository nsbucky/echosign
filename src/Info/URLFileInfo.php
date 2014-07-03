<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class URLFileInfo implements InfoInterface {

    public $name;
    public $url;
    public $mimeType;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name'     => $this->name,
            'url'      => $this->url,
            'mimeType' => $this->mimeType
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