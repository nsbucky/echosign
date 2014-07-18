<?php namespace Echosign;

use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;
use Echosign\Responses\Error;

class Widget implements RequestEntityInterface {

    const END_POINT = '/widgets';
    protected $endPoint;

    protected $token;

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

    public function create()
    {

    }

    public function getAll()
    {

    }

    public function get()
    {

    }

    public function documents()
    {

    }

    /**
     * @param $widgetId
     * @param $documentId
     * @param $fileName
     * @throws \RuntimeException when savePath is not writeable
     * @return boolean|string path to saved file
     */
    public function document($widgetId, $documentId, $fileName)
    {
        $this->endPoint = $widgetId .'/documents/'.$documentId;

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
        ];

        $this->saveToPath = $fileName;

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        if( ! is_readable( $fileName ) ) {
            return false;
        }

        return $fileName;
    }

    /**
     * @param $widgetId
     * @param $fileName
     * @return bool|string
     * @throws \RuntimeException
     */
    public function auditTrail($widgetId, $fileName)
    {
        $this->endPoint = $widgetId . '/auditTrail';

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
        ];

        $this->saveToPath = $fileName;

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        if( ! is_readable( $fileName ) ) {
            return false;
        }

        return $fileName;
    }

    /**
     * @param $widgetId
     * @param string $fileName /path/to/fileName.ext
     * @param null $versionId
     * @param null $participantEmail
     * @param bool $auditReport
     * @return bool|string
     * @throws \RuntimeException
     */
    public function combinedDocument($widgetId, $fileName, $versionId=null, $participantEmail=null, $auditReport=false)
    {
        $query = [
            'versionId'                 => $versionId,
            'participantEmail'          => $participantEmail,
            'auditReport'               => $auditReport,
        ];

        $this->endPoint = $widgetId .'/combinedDocument?'.http_build_query($query) ;


        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
        ];

        $this->saveToPath = $fileName;

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        if( ! is_readable( $fileName ) ) {
            return false;
        }

        return $fileName;
    }

    /**
     * will return a csv file
     * @param $widgetId
     * @param $fileName
     * @return bool|string
     */
    public function formData($widgetId, $fileName)
    {
        $this->endPoint = $widgetId .'/formData';

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
        ];

        $this->saveToPath = $fileName;

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        if( ! is_readable( $fileName ) ) {
            return false;
        }

        return $fileName;
    }

    public function agreements()
    {

    }

    public function personalize()
    {

    }

    public function status()
    {

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
        if( $this->endPoint ) {
            return self::END_POINT . '/ ' . $this->endPoint;
        }

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
        return $this->transport;
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
     * @return string
     */
    public function getBody()
    {
        return $this->toJson();
    }

    /**
     * @return string
     */
    public function getSaveTo()
    {
        return $this->saveToPath;
    }


}