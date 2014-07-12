<?php namespace Echosign;

use Echosign\Info\AgreementCreationInfo;
use Echosign\Info\DocumentCreationInfo;
use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;
use Echosign\Options\InteractiveOptions;
use Echosign\Responses\AgreementCreationResponse;
use Echosign\Responses\AgreementDocuments;
use Echosign\Responses\AgreementInfo;
use Echosign\Responses\AgreementStatusUpdateResponse;
use Echosign\Responses\SigningUrls;
use Echosign\Responses\UserAgreements;
use Echosign\Info\AgreementStatusUpdateInfo;
use Echosign\Responses\Error;
use Echosign\Transports\Guzzle;

class Agreement implements RequestEntityInterface {

    const END_POINT = '/agreements';

    /**
     * @var string
     */
    protected $endPoint = '';

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

    protected $data = [];

    /**
     * @param Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
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
            'Content-Type' => 'application/json',
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

        return new UserAgreements( $response, $this );
    }

    /**
     * @param null $agreementId
     * @return AgreementInfo|Error
     */
    public function get($agreementId)
    {
        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
            'agreementId'  => $agreementId,
        ];

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return new AgreementInfo( $response, $this );
    }

    /**
     * @param $agreementId
     * @param null $versionId
     * @param null $participantEmail
     * @param null $supportingDocumentContentFormat
     * @return Error|AgreementDocuments
     */
    public function documents($agreementId, $versionId=null, $participantEmail=null, $supportingDocumentContentFormat=null)
    {
        $query = array_filter([
            'versionId'=> $versionId,
            'participantEmail'=>$participantEmail,
            'supportingDocumentContentFormat'=>$supportingDocumentContentFormat
        ]);

        $this->endPoint = $agreementId .'/documents?'.http_build_query($query) ;

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
            'agreementId'  => $agreementId,
        ];

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return new AgreementDocuments( $response, $this, $agreementId );
    }

    /**
     * @param $agreementId
     * @param $documentId
     * @throws \RuntimeException when savePath is not writeable
     * @return boolean|string path to saved file
     */
    public function document($agreementId, $documentId)
    {
        $this->endPoint = $agreementId .'/documents/'.$documentId;

        $savePath = sys_get_temp_dir();

        if( ! is_writable( $savePath ) ) {
            throw new \RuntimeException("$savePath is not writeable by server.");
        }

        $fileName = $savePath . DIRECTORY_SEPARATOR . substr( $documentId, 0, 16);

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
            'agreementId'  => $agreementId,
            'documentId'   => $documentId,
            'save_to'      => $fileName,
        ];

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
     * @param $agreementId
     * @return bool|string
     * @throws \RuntimeException
     */
    public function auditTrail($agreementId)
    {
        $this->endPoint = $agreementId . '/auditTrail';

        $savePath = sys_get_temp_dir();

        if( ! is_writable( $savePath ) ) {
            throw new \RuntimeException("$savePath is not writeable by server.");
        }

        $fileName = $savePath . DIRECTORY_SEPARATOR . substr( $agreementId, 0, 16). '.pdf';

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
            'agreementId'  => $agreementId,
            'save_to'      => $fileName,
        ];

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
     * @param $agreementId
     * @return SigningUrls
     */
    public function signingUrls($agreementId)
    {
        $this->endPoint = $agreementId . '/signingUrls';

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
            'agreementId'  => $agreementId,
        ];

        $this->data = [];
        $request  = $this->getTransport();
        $response = $request->get($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return new SigningUrls( $response );
    }

    public function combinedDocument($agreementId, $versionId=null, $participantEmail=null, $attachSupportingDocuments=false, $auditReport=false)
    {
        $query = [
            'versionId'                 => $versionId,
            'participantEmail'          => $participantEmail,
            'attachSupportingDocuments' => $attachSupportingDocuments,
            'auditReport'               => $auditReport,
        ];

        $this->endPoint = $agreementId .'/combinedDocument?'.http_build_query($query) ;

        $savePath = sys_get_temp_dir();

        if( ! is_writable( $savePath ) ) {
            throw new \RuntimeException("$savePath is not writeable by server.");
        }

        $fileName = $savePath . DIRECTORY_SEPARATOR . substr( $agreementId, 0, 16). '.pdf';

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
            'agreementId'  => $agreementId,
            'save_to'      => $fileName,
        ];

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
     * @param $agreementId
     * @param AgreementStatusUpdateInfo $info
     * @return AgreementStatusUpdateResponse
     */
    public function status( $agreementId, AgreementStatusUpdateInfo $info )
    {
        $this->endPoint = $agreementId . '/status';

        $this->headers = [
            'Access-Token' => $this->token->getAccessToken(),
            'agreementId'  => $agreementId,
        ];

        $this->data = $info->toArray();

        $request  = $this->getTransport();
        $response = $request->put($this);

        if( $response instanceof Error ) {
            return $response;
        }

        return new AgreementStatusUpdateResponse( $response );
    }

    /**
     * @param $agreementId
     * @param null $comment
     * @param bool $notifySigner
     * @return AgreementStatusUpdateResponse
     */
    public function cancel( $agreementId, $comment=null, $notifySigner=false )
    {
        $info = new AgreementStatusUpdateInfo( $comment, $notifySigner );
        return $this->status( $agreementId, $info );
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
        return self::END_POINT . '/' .$this->endPoint;
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


}