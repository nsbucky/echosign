<?php namespace Echosign;

use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;
use Echosign\Responses\TransientDocuments;
use Echosign\Transports\Guzzle;
use Echosign\Responses\Error;

class TransientDocument implements RequestEntityInterface {

    const END_POINT = '/transientDocuments';

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var sting
     */
    protected $fileName;

    /**
     * @var string
     */
    protected $mimeType;

    protected $transientDocument;

    /**
     * @param Token $token
     * @param $filePath
     * @param null $mimeType
     */
    public function __construct(Token $token, $filePath, $mimeType=null)
    {
        $this->token    = $token;
        $this->filePath = $filePath;
        $this->fileName = basename( $this->filePath );
        $this->mimeType = $mimeType;
    }

    /**
     * @return sting|string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return mixed|null|string
     */
    public function getMimeType()
    {
        if( isset($this->mimeType) && !is_null($this->mimeType) ) {
            return $this->mimeType;
        }

        // try to detect it based on fileinfo
        if( function_exists('finfo_open') ) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file( $finfo, $this->filePath );
            finfo_close($finfo);
            return $type;
        }

        return null;
    }

    /**
     * @return bool|Error
     */
    public function send()
    {
        $request = $this->getTransport();
        $response = $request->post($this);

        if( $response instanceof Error ) {
            return $response;
        }

        // create new response
        $this->transientDocument = new TransientDocuments( $response );
        return $this->transientDocument;
    }

    /**
     * @return string
     */
    public function getDocumentId()
    {
        return $this->transientDocument->getId();
    }

    /**
     * @return TransientDocuments
     */
    public function getDocument()
    {
        return $this->transientDocument;
    }

    /**
     * @return array
     * @throws \RuntimeException
     */
    public function toArray()
    {
        // check if file is writeable!
        if( ! is_readable( $this->filePath ) ) {
            throw new \RuntimeException($this->filePath . ' is not readable.' );
        }

        return [
            'Access-Token' => $this->token->getAccessToken(),
            'File-Name'    => $this->fileName,
            'Mime-Type'    => $this->mimeType,
            'File'         => fopen($this->filePath, 'r')
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
        if( isset( $this->transport ) ) {
            return $this->transport;
        }

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
        return [
            'Access-Token'=>$this->getAccessToken()
        ];
    }

    public function getBody()
    {
        return $this->toArray();
    }

}