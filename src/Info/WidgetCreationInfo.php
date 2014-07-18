<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;
use Echosign\Options\WidgetSecurityOption;

class WidgetCreationInfo implements InfoInterface {

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
    public $locale = 'en_US';

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
    protected $ccs = [ ];
    protected $vaultingInfo;
    protected $mergeFieldInfo = [ ];
    protected $fileInfos = [ ];
    protected $widgetCompletionInfo;
    protected $counterSigners = [];
    protected $widgetAuthFailureInfo;

    /**
     * @param WidgetCompletionInfo $widgetCompletionInfo
     * @param WidgetFileInfo $fileInfo
     * @param $name
     * @param $signatureType
     * @param $signatureFlow
     */
    public function __construct( WidgetCompletionInfo $widgetCompletionInfo, WidgetFileInfo $fileInfo, $name, $signatureType, $signatureFlow )
    {
        $this->widgetCompletionInfo = $widgetCompletionInfo;

        $this->fileInfos[] = $fileInfo;

        $this->setName($name);

        $this->setSignatureType($signatureType);

        $this->setSignatureFlow($signatureFlow);
    }

    /**
     * @param mixed $widgetAuthFailureInfo
     */
    public function setWidgetAuthFailureInfo( WidgetCompletionInfo $widgetAuthFailureInfo )
    {
        $this->widgetAuthFailureInfo = $widgetAuthFailureInfo;
    }

    /**
     * @param CounterSignerInfo $counterSigners
     */
    public function setCounterSigners( CounterSignerInfo $counterSigners )
    {
        $this->counterSigners[] = $counterSigners;
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
     * @throws \InvalidArgumentException
     */
    public function setSignatureType($type)
    {
        $allowed = ['ESIGN','WRITTEN'];
        if( ! in_array($type, $allowed)) {
            throw new \InvalidArgumentException('Invalid signature type provided. Must be one of: ' . implode(', ', $allowed) );
        }

        $this->signatureType = $type;

        return $this;
    }

    /**
     * @param string $signatureFlow
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setSignatureFlow( $signatureFlow )
    {
        $allowed = ['SENDER_SIGNATURE_NOT_REQUIRED', 'SENDER_SIGNS_LAST', 'SENDER_SIGNS_FIRST'];
        if( ! in_array($signatureFlow, $allowed)) {
            throw new \InvalidArgumentException('Invalid signature flow provided. Must be one of: ' . implode(', ', $allowed) );

        }

        $this->signatureFlow = $signatureFlow;

        return $this;
    }

    /**
     * @param WidgetFileInfo $info
     * @return $this
     */
    public function addFormFieldLayerTemplate( WidgetFileInfo $info )
    {
        $this->formFieldLayerTemplates[] = $info;

        return $this;
    }

    /**
     * @param WidgetSecurityOption $option
     * @return $this
     */
    public function addSecurityOption( WidgetSecurityOption $option )
    {
        $this->securityOptions = $option;

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
     * @param WidgetMergefieldInfo $info
     * @return $this
     */
    public function addMergeFieldInfo( WidgetMergefieldInfo $info )
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
     * @param WidgetVaultingInfo $vaultingInfo
     * @return $this
     */
    public function addVaultingInfo( WidgetVaultingInfo $vaultingInfo )
    {
        $this->vaultingInfo = $vaultingInfo;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'widgetCompletionInfo'     => $this->widgetCompletionInfo->toArray(),
            'signatureType'            => $this->signatureType,
            'callbackinfo'             => $this->callbackinfo,
            'daysUntilSigningDeadline' => $this->daysUntilSigningDeadline,
            'locale'                   => $this->locale,
            'signatureFlow'            => $this->signatureFlow,
            'message'                  => $this->message,
            'reminderFrequency'        => $this->reminderFrequency,
            'name'                     => $this->name,
            'ccs'                      => $this->ccs,
        ];

        if( $this->widgetAuthFailureInfo ) {
            $data['widgetAuthFailureInfo'] = $this->widgetAuthFailureInfo->toArray();
        }

        if( count( $this->counterSigners ) ) {
            $data['counterSigners'] = [];
            foreach( $this->counterSigners as $c ) {
                $data['counterSigners'][] = $c->toArray();
            }
        }

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

        return array_filter( $data );
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }

}