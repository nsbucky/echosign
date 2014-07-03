<?php namespace Echosign\Credentials;

use Echosign\Interfaces\CredentialInterface;

class User implements CredentialInterface {

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @param null $apiKey
     * @param null $email
     * @param null $password
     */
    public function __construct($apiKey=null, $email=null, $password=null)
    {
        $this->email    = $email;
        $this->password = $password;
        $this->apiKey   = $apiKey;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'email'    => $this->email,
            'password' => $this->password,
            'apiKey'   => $this->apiKey,
        ];
    }


}