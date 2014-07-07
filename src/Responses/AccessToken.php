<?php namespace Echosign\Responses;

class AccessToken {

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var integer
     */
    protected $expiresIn;

    public function __construct(array $response)
    {                
        $this->accessToken = $response['accessToken'];
        $this->expiresIn   = $response['expiresIn'];
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }
}