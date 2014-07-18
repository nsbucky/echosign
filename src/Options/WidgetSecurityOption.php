<?php namespace Echosign\Options;

use Echosign\Interfaces\OptionsInterface;

class WidgetSecurityOption implements OptionsInterface {

    protected $passwordProtection;
    protected $kbaProtection;
    protected $webIdentityProtection;
    public $protectOpen;
    public $internalPassword;
    public $externalPassword;
    public $openPassword;

    /**
     * @param mixed $passwordProtection
     * @throws \InvalidArgumentException
     */
    public function setPasswordProtection( $passwordProtection )
    {
        if( ! in_array($passwordProtection, ['NONE', 'EXTERNAL_USERS', 'INTERNAL_USERS', 'ALL_USERS']) ) {
            throw new \InvalidArgumentException('Invalid passwordProtection value');
        }
        $this->passwordProtection = $passwordProtection;
    }

    /**
     * @return mixed
     */
    public function getPasswordProtection()
    {
        return $this->passwordProtection;
    }

    /**
     * @param mixed $kbaProtection
     * @throws \InvalidArgumentException
     */
    public function setKbaProtection( $kbaProtection )
    {
        if( ! in_array($kbaProtection, ['NONE', 'EXTERNAL_USERS', 'INTERNAL_USERS', 'ALL_USERS']) ) {
            throw new \InvalidArgumentException('Invalid passwordProtection value');
        }
        $this->kbaProtection = $kbaProtection;
    }

    /**
     * @return mixed
     */
    public function getKbaProtection()
    {
        return $this->kbaProtection;
    }

    /**
     * @param mixed $webIdentityProtection
     * @throws \InvalidArgumentException
     */
    public function setWebIdentityProtection( $webIdentityProtection )
    {
        if( ! in_array($webIdentityProtection, ['NONE', 'EXTERNAL_USERS', 'INTERNAL_USERS', 'ALL_USERS']) ) {
            throw new \InvalidArgumentException('Invalid passwordProtection value');
        }
        $this->webIdentityProtection = $webIdentityProtection;
    }

    /**
     * @return mixed
     */
    public function getWebIdentityProtection()
    {
        return $this->webIdentityProtection;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'passwordProtection'=>$this->passwordProtection,
            'kbaProtection'=>$this->kbaProtection,
            'webIdentityProtection'=>$this->webIdentityProtection,
            'protectOpen'=>$this->protectOpen,
            'internalPassword'=>$this->internalPassword,
            'externalPassword'=>$this->externalPassword,
            'openPassword'=>$this->openPassword,
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