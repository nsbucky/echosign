<?php namespace Echosign\Options;

class WidgetSignerSecurityOption {

    public $password;
    protected $authenticationMethod;
    protected $phoneInfos = [];

    public function __construct( $authenticationMethod, $password )
    {
        $this->setAuthenticationMethod($authenticationMethod);
        $this->password = $password;
    }

    /**
     * @param mixed $authenticationMethod
     * @throws \InvalidArgumentException
     */
    public function setAuthenticationMethod( $authenticationMethod )
    {
        if( ! in_array($authenticationMethod, ['INHERITED_FROM_DOCUMENT','KBA','PASSWORD','WEB_IDENTITY','PHONE', 'NONE']) ) {
            throw new \InvalidArgumentException('invalid authentication method supplied');
        }

        $this->authenticationMethod = $authenticationMethod;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $options = [
            'password' => $this->password,
            'authenticationMethod' => $this->authenticationMethod,
        ];

        if( count( $this->phoneInfos ) ) {
            $data['phoneInfo'] = [];
            foreach( $this->phoneInfos as $p ) {
                $options['phoneInfo'][] = $p->toArray();
            }
        }

        return array_filter($options);
    }

    /**
     * @return mixed
     */
    public function getAuthenticationMethod()
    {
        return $this->authenticationMethod;
    }

    /**
     * @param mixed $password
     */
    public function setPassword( $password )
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param PhoneInfo $phoneInfos
     */
    public function setPhoneInfos( PhoneInfo $phoneInfos )
    {
        $this->phoneInfos[] = $phoneInfos;
    }

    /**
     * @return array
     */
    public function getPhoneInfos()
    {
        return $this->phoneInfos;
    }


}