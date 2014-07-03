<?php namespace Echosign\Options;

use Echosign\Interfaces\OptionsInterface;

class InteractiveOptions implements OptionsInterface {

    public $noChrome;
    public $authoringRequested;
    public $autoLoginUser;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'noChrome' =>  (bool) $this->noChrome,
            'authoringRequested'=> (bool) $this->authoringRequested,
            'autoLoginUser'=> (bool) $this->autoLoginUser
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