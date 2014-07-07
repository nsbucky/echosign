<?php namespace Echosign;

use Echosign\Credentials\Application;
use Echosign\Credentials\User;
use Echosign\Responses\AccessToken;
use Echosign\Responses\Error;
use Echosign\Transports\Guzzle;
use Echosign\Interfaces\TransportInterface;
use Echosign\Interfaces\RequestEntityInterface;

class Token implements RequestEntityInterface {

    const END_POINT = '/auth/tokens';

    /**
     * @var User
     */
    protected $userCredentials;

    /**
     * @var Application
     */
    protected $applicationCredentials;

    /**
     * @var AccessToken
     */
    protected $accessToken;


    /**
     * @var Request
     */
    protected $transport;

    /**
     * @param $applicationId
     * @param $applicationSecret
     * @param null $apiKey
     * @param null $email
     * @param null $password
     */
    public function __construct( $applicationId, $applicationSecret, $apiKey=null, $email=null, $password=null)
    {
        $this->userCredentials = new User( $apiKey, $email, $password);
        $this->applicationCredentials = new Application($applicationSecret, $applicationId);
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->userCredentials;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        return $this->applicationCredentials;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'userCredentials'        => $this->userCredentials->toArray(),
            'applicationCredentials' => $this->applicationCredentials->toArray(),
        ];
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }

    /**
     * @return bool|Error
     */
    public function authenticate()
    {
        $request = $this->getTransport();

        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        $this->accessToken = new AccessToken( $response );
        return true;
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        if( ! isset($this->accessToken) ) {
            return false;
        }

        $token = $this->accessToken->getAccessToken();

        return ! empty($token);
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return self::END_POINT;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken->getAccessToken();
    }

    /**
     * @return integer|null
     */
    public function getExpiresIn()
    {
        return $this->accessToken->getExpiresIn();
    }

    /**
     * @param TransportInterface $transport
     * @return $this;
     */
    public function setTransport( TransportInterface $transport )
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return TransportInterface
     */
    public function getTransport()
    {
        if( isset($this->transport) ) {
            return $this->transport;
        }

        // create a default transport just in case.
        $this->transport = new Guzzle();
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Accept' => 'application/json'
        ];
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->toJson();
    }

}