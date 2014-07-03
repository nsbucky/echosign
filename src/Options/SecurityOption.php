<?php namespace Echosign\Options;

use Echosign\Interfaces\OptionsInterface;

class SecurityOption implements OptionsInterface {

    public $passwordProtection;
    public $kbaProtection;
    public $webIdentityProtection;
    public $protectOpen;
    public $internalPassword;
    public $externalPassword;
    public $openPassword;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'passwordProtection'=>$this->passwordProtection,
            'kbaProtection'=>$this->kbaProtection,
            'webIdentityProtection'=>$this->webIdentityProtection,
            'protectOpen'=>$this->protectOpen,
            'internalPassword'=>$this->internalPassword,
            'externalPassword'=>$this->externalPassword,
            'openPassword'=>$this->openPassword,
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