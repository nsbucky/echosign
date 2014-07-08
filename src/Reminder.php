<?php namespace Echosign;

use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;
use \Echosign\Credentials\Reminder as ReminderCredentials;
use Echosign\Responses\ReminderCreationResult;
use Echosign\Transports\Guzzle;
use Echosign\Responses\Error;

class Reminder implements RequestEntityInterface {

    const END_POINT = '/reminders';

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var Credentials\Reminder
     */
    protected $reminderCredentials;

    /**
     * @var TransportInterface
     */
    protected $transport;

    protected $headers = [];

    /**
     * @param Token $token
     * @param $agreementId
     * @param null $comment
     */
    public function __construct( Token $token, $agreementId, $comment=null )
    {
        $this->token = $token;
        $this->reminderCredentials = new ReminderCredentials($agreementId, $comment);
    }

    /**
     * @return ReminderCreationResult
     */
    public function create()
    {
        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
        ];

        $request  = $this->getTransport();
        $response = $request->post($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return new ReminderCreationResult( $response );
    }

    /**
     * @return ReminderCredentials
     */
    public function getCredentials()
    {
        return $this->reminderCredentials;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->reminderCredentials->toArray();
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