<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;
use Echosign\Options\SecurityOption;
use Echosign\TransientDocument;

class DocumentCreationInfo implements InfoInterface {

    const SIGN_ESIGN = 'ESIGN';
    const SIGN_WRITTEN = 'WRITTEN';
    const FLOW_NOT_REQUIRED = 'SENDER_SIGNATURE_NOT_REQUIRED';
    const FLOW_SIGNS_LAST = 'SENDER_SIGNS_LAST';
    const FLOW_SIGNS_FIRST = 'SENDER_SIGNS_FIRST';

    /**
     * ['ESIGN' or 'WRITTEN']:
     * @var string
     */
    protected $signatureType = 'ESIGN';
    public $callbackinfo;
    public $daysUntilSigningDeadline;
    public $locale;

    /**
     * SENDER_SIGNATURE_NOT_REQUIRED, SENDER_SIGNS_LAST, or SENDER_SIGNS_FIRST
     * @var string
     */
    protected  $signatureFlow;
    public $message;
    public $reminderFrequency;
    protected $name;

    protected $formFieldLayerTemplates = [ ];
    protected $securityOptions;
    protected $recipients = [ ];
    protected $ccs = [ ];
    protected $vaultingInfo;
    protected $mergeFieldInfo = [ ];
    protected $fileInfos = [ ];

    /**
     * @param $transientDocumentId
     * @param $name
     * @param $signerEmail
     * @param $signatureType
     * @param $signatureFlow
     */
    public function __construct( $transientDocumentId, $name, $signerEmail, $signatureType, $signatureFlow )
    {
        if( $transientDocumentId instanceof TransientDocument ) {
            $this->addTransientDocument( $transientDocumentId );
        }

        if( is_scalar( $transientDocumentId ) ) {
            $info = new FileInfo;
            $info->transientDocumentId = $transientDocumentId;
            $this->fileInfos[] = $info;
        }

        $this->setAgreementName($name);

        $this->setSignatureType($signatureType);

        $this->addRecipient($signerEmail, null, 'SIGNER');

        $this->setSignatureFlow($signatureFlow);
    }

    /**
     * @param $name
     * @return $this
     */
    public function setAgreementName($name)
    {
        $this->name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        return $this;
    }

    /**
     * proxy see @setAgreementName
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setAgreementName($name);
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * for example en_US or fr_FR
     * @param $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        // for example en_US or fr_FR
        $this->locale = $locale;
        return $this;
    }

    /**
     * @param integer $numDays
     * @return $this
     */
    public function setDeadline($numDays)
    {
        $this->daysUntilSigningDeadline = (int) $numDays;
        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setCallBackInfo($url)
    {
        $this->callbackinfo = filter_var($url, FILTER_SANITIZE_URL);
        return $this;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setSignatureType($type)
    {
        if( in_array($type, ['ESIGN','WRITTEN'])) {
            $this->signatureType = $type;
        }

        return $this;
    }

    /**
     * @param string $signatureFlow
     * @return $this
     */
    public function setSignatureFlow( $signatureFlow )
    {
        if( in_array($signatureFlow, ['SENDER_SIGNATURE_NOT_REQUIRED', 'SENDER_SIGNS_LAST', 'SENDER_SIGNS_FIRST'])) {
            $this->signatureFlow = $signatureFlow;
        }

        return $this;
    }



    /**
     * @param FileInfo $info
     * @return $this
     */
    public function addFormFieldLayerTemplate( FileInfo $info )
    {
        $this->formFieldLayerTemplates[] = $info;

        return $this;
    }

    /**
     * @param SecurityOption $option
     * @return $this
     */
    public function addSecurityOption( SecurityOption $option )
    {
        $this->securityOptions = $option;

        return $this;
    }

    /**
     * @param RecipientInfo $recipient
     * @return $this
     */
    public function addRecipients( RecipientInfo $recipient )
    {
        $this->recipients[] = $recipient;

        return $this;
    }

    /**
     * @param null $email
     * @param null $fax
     * @param null $role
     * @return $this
     */
    public function addRecipient( $email=null, $fax=null, $role=null )
    {
        $info = new RecipientInfo( $email, $fax, $role);
        $this->recipients[] = $info;
        return $this;
    }

    /**
     * @param $email
     * @return $this
     */
    public function addCC( $email )
    {
        $this->ccs[] = filter_var($email, FILTER_SANITIZE_EMAIL);

        return $this;
    }

    /**
     * @param MergefieldInfo $info
     * @return $this
     */
    public function addMergeFieldInfo( MergefieldInfo $info )
    {
        $this->mergeFieldInfo[] = $info;

        return $this;
    }

    /**
     * @param FileInfo $info
     * @return $this
     */
    public function addFileInfo( FileInfo $info )
    {
        $this->fileInfos[] = $info;

        return $this;
    }

    /**
     * set this transient document as the one to be signed
     * @param TransientDocument $document
     * @return $this
     */
    public function addTransientDocument( TransientDocument $document )
    {
        $info = new FileInfo();
        $info->transientDocumentId = $document->getDocumentId();
        $this->fileInfos[] = $info;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'signatureType'            => $this->signatureType,
            'callbackinfo'             => $this->callbackinfo,
            'daysUntilSigningDeadline' => $this->daysUntilSigningDeadline,
            'locale'                   => $this->locale,
            'signatureFlow'            => $this->signatureFlow,
            'message'                  => $this->message,
            'reminderFrequency'        => $this->reminderFrequency,
            'name'                     => $this->name,
            'ccs'                      => $this->ccs
        ];

        if( count( $this->formFieldLayerTemplates ) ) {
            $data['formFieldLayerTemplates'] = [];
            foreach( $this->formFieldLayerTemplates as $t ) {
                $data['formFieldLayerTemplates'][] = $t->toArray();
            }
        }

        if( count( $this->fileInfos ) ) {
            $data['fileInfos'] = [];
            foreach( $this->fileInfos as $t ) {
                $data['fileInfos'][] = $t->toArray();
            }
        }

        if( count( $this->recipients ) ) {
            $data['recipients'] = [];
            foreach( $this->recipients as $t ) {
                $data['recipients'][] = $t->toArray();
            }
        }

        if( count( $this->mergeFieldInfo ) ) {
            $data['mergeFieldInfo'] = [];
            foreach( $this->mergeFieldInfo as $t ) {
                $data['mergeFieldInfo'][] = $t->toArray();
            }
        }

        if( $this->securityOptions ) {
            $data['securityOptions'] = $this->securityOptions->toArray();
        }

        if( $this->vaultingInfo ) {
            $data['vaultingInfo'] = $this->vaultingInfo->toArray();
        }

        return $data;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}