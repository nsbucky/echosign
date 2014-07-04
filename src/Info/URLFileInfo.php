<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class URLFileInfo implements InfoInterface {

    protected  $name;
    protected  $url;
    protected  $mimeType;

    public function __construct( $name, $url, $mimeType=null)
    {
        $this->name = $name;
        $this->url  = filter_var($url, FILTER_SANITIZE_URL);
        $this->mimeType = $mimeType;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'name'     => $this->name,
            'url'      => $this->url,
            'mimeType' => $this->mimeType
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