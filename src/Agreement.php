<?php namespace Echosign;

use Echosign\Info\AgreementCreationInfo;
use Echosign\Info\DocumentCreationInfo;
use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;
use Echosign\Options\InteractiveOptions;

class Agreement implements RequestEntityInterface {

    /**
     * @var string
     */
    protected $endPoint = '/agreements';

    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var Token
     */
    protected $token;

    /**
     * @var array
     */
    protected $headers = [];

    protected $agreementId;

    protected $data = [];

    /**
     * @param Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function create( DocumentCreationInfo $documentCreationInfo, InteractiveOptions $interactiveOptions = null, $userId=null, $userEmail=null )
    {
        $this->headers = [
            'Accept'       => 'application/json',
            'Access-Token' => $this->token->getAccessToken(),
            'X-User-Id'    => $userId,
            'X-User-Email' => $userEmail
        ];

        // set the agreementId;
        $this->data['AgreementCreationInfo'] = new AgreementCreationInfo( $documentCreationInfo, $interactiveOptions );
    }

    public function get($agreementId)
    {
        $this->endPoint .= '/'.$agreementId;
        $this->agreementId = $agreementId;
    }

    public function documents()
    {
        $this->endPoint .= '/'.$this->agreementId .'/documents';
    }

    public function document($documentId)
    {
        $this->endPoint .= '/'.$this->agreementId .'/documents/'.$documentId;
    }

    public function auditTrail()
    {
        $this->endPoint .= '/'.$this->agreementId . '/auditTrail';
    }

    public function signingUrls()
    {
        $this->endPoint .= '/'.$this->agreementId . '/signingUrls';
    }

    public function combinedDocument()
    {
        $this->endPoint .= '/'.$this->agreementId . '/combinedDocument';
    }

    public function status()
    {
        $this->endPoint .= '/'.$this->agreementId . '/status';
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
        return $this->endPoint;
    }

    /**
     * @param TransportInterface $transport
     */
    public function setTransport( TransportInterface $transport )
    {
        $this->transport = $transport;
    }

    /**
     * @return TransportInterface
     */
    public function getTransport()
    {
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


}