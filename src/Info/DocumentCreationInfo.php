<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;
use Echosign\Options\SecurityOption;

class DocumentCreationInfo implements InfoInterface {

    /**
     * ['ESIGN' or 'WRITTEN']:
     * @var string
     */
    public $signatureType = 'ESIGN';
    public $callbackinfo;
    public $daysUntilSigningDeadline;
    public $locale;

    /**
     * SENDER_SIGNATURE_NOT_REQUIRED, SENDER_SIGNS_LAST, or SENDER_SIGNS_FIRST
     * @var string
     */
    public $signatureFlow;
    public $message;
    public $reminderFrequency;
    public $name;

    protected $formFieldLayerTemplates = [ ];
    protected $securityOptions;
    protected $recipients = [ ];
    protected $ccs = [ ];
    protected $vaultingInfo;
    protected $mergeFieldInfo = [ ];
    protected $fileInfos = [ ];

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

    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}