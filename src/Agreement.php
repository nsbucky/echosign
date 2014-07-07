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
        /* smaple response
        {
  "events": [
    {
      "actingUserEmail": "kenrick@specificperformance.com",
      "actingUserIpAddress": "98.176.93.174",
      "date": "2014-07-04T07:17:50-07:00",
      "description": "Document created by Kenrick Buchanan",
      "participantEmail": "kenrick@specificperformance.com",
      "type": "CREATED",
      "versionId": "2AAABLblqZhCdrS_jN9CPseEm_i5suppmf-gZtC51kDY249ocj5e1dBwYEDJiP1ok0olHGOmcpsA*"
    },
    {
      "actingUserEmail": "kenrick@specificperformance.com",
      "date": "2014-07-04T07:17:51-07:00",
      "description": "Sent out for signature to nsbucky@gmail.com",
      "participantEmail": "nsbucky@gmail.com",
      "type": "SIGNATURE_REQUESTED"
    }
  ],
  "latestVersionId": "2AAABLblqZhDIxXlCh5Wt1rdQsVBRUcn6BZ__P8I7oCP97ywr7RDStz8eWMZyRg9woOR9Y2-r-Cs*",
  "locale": "en_US",
  "message": "please sign",
  "name": "[DEMO USE ONLY] sample agreement",
  "participants": [
    {
      "email": "nsbucky@gmail.com",
      "name": "",
      "roles": [
        "SIGNER"
      ],
      "status": "WAITING_FOR_MY_SIGNATURE"
    },
    {
      "company": "Specific Performance, LLC",
      "email": "kenrick@specificperformance.com",
      "name": "Kenrick Buchanan",
      "roles": [
        "SENDER"
      ],
      "status": "OUT_FOR_SIGNATURE",
      "title": "IT"
    }
  ],
  "status": "OUT_FOR_SIGNATURE",
  "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
  "nextParticipantInfos": [
    {
      "email": "nsbucky@gmail.com",
      "name": "",
      "waitingSince": "2014-07-04T07:17:50-07:00"
    }
  ]
}*/
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