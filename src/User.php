<?php namespace Echosign;

use Echosign\Info\UserCreationInfo;
use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;
use Echosign\Responses\UsersInfo;
use Echosign\Transports\Guzzle;
use Echosign\Responses\Error;

class User implements RequestEntityInterface {

    const END_POINT = '/users';

    protected $token;

    /**
     * @var UserCreationInfo
     */
    protected $userCreationInfo;

    protected $data = [];
    protected $headers = [];

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @param Token $token
     */
    public function __construct( Token $token)
    {
        $this->token = $token;
    }

    /**
     * @param UserCreationInfo $info
     * @return bool
     */
    public function create( UserCreationInfo $info )
    {
        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
        ];

        $this->data = $info->toArray();

        $request  = $this->getTransport();
        $response = $request->post($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return true;
    }

    /**
     * @return UsersInfo
     */
    public function get()
    {
        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
        ];

        $this->data = [];

        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return new UsersInfo( $response );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return self::END_POINT;
    }

    /**
     * @param TransportInterface $transport
     * @return $this
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
     * @return string
     */
    public function getAccessToken()
    {
        return $this->token->getAccessToken();
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->toJson();
    }


}