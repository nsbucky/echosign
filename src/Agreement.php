<?php namespace Echosign;

use Echosign\Info\AgreementCreationInfo;
use Echosign\Info\DocumentCreationInfo;
use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;
use Echosign\Options\InteractiveOptions;
use Echosign\Responses\AgreementCreationResponse;
use Echosign\Responses\AgreementInfo;
use Echosign\Responses\UserAgreements;

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
     * @param $agreementId
     */
    public function __construct(Token $token, $agreementId=null)
    {
        $this->token = $token;

        if( null !== $agreementId ) {
            $this->agreementId = $agreementId;
        }
    }

    /**
     * @param DocumentCreationInfo $documentCreationInfo
     * @param InteractiveOptions $interactiveOptions
     * @param null $userId
     * @param null $userEmail
     * @return AgreementCreationResponse|Error
     */
    public function create( DocumentCreationInfo $documentCreationInfo, InteractiveOptions $interactiveOptions = null, $userId=null, $userEmail=null )
    {
        $this->headers = array_filter([
            'Accept'       => 'application/json',
            'Access-Token' => $this->token->getAccessToken(),
            'X-User-Id'    => $userId,
            'X-User-Email' => $userEmail
        ]);

        // set this data to be called by transport
        $this->data = new AgreementCreationInfo( $documentCreationInfo, $interactiveOptions );

        $request  = $this->getTransport();
        $response = $request->post($this);

        if( $response instanceof Error ) {
            return $response;
        }

        $this->agreementId = $response['agreementId'];
        return new AgreementCreationResponse( $response );
    }

    /**
     * get all user agreements
     * @param null $userId
     * @param null $userEmail
     * @return UserAgreements
     */
    public function getAll( $userId=null, $userEmail=null  )
    {
        // load an agreement
        $this->headers = array_filter([
            'Access-Token' => $this->token->getAccessToken(),
            'X-User-Id'    => $userId,
            'X-User-Email' => $userEmail
        ]);

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return new UserAgreements( $response );
    }

    /**
     * @param null $agreementId
     * @return AgreementInfo
     */
    public function get($agreementId=null)
    {
        if( null !== $agreementId ) {
            $this->agreementId = $agreementId;
        }

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
        ];

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return new AgreementInfo( $response );
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

    public function cancel()
    {
        return $this->status();
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