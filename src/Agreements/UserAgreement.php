<?php namespace Echosign\Agreements;

use Echosign\Agreement;
use Echosign\Info\DisplayUserInfo;
use Echosign\Status\UserDocumentStatus;

class UserAgreement {

    public $displayDate;
    protected $status;
    protected $displayUserInfo;
    public $agreementId;
    public $esign;
    public $lastestVersionId;
    protected $agreement;

    /**
     * @param array $response
     * @param Agreement $agreement
     */
    public function __construct( array $response, Agreement $agreement )
    {
        $this->displayDate      = \DateTime::createFromFormat( \DateTime::W3C, $response['displayDate'] );
        $this->status           = new UserDocumentStatus( $response['status'] );
        $this->name             = $response['name'];
        $this->displayUserInfo  = new DisplayUserInfo( \Echosign\array_get( $response['displayUserInfo'], 'company'), \Echosign\array_get($response['displayUserInfo'], 'fullNameOrEmail') );
        $this->agreementId      = $response['agreementId'];
        $this->esign            = (bool) $response['esign'];
        $this->lastestVersionId = $response['latestVersionId'];
        $this->agreement        = $agreement;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status->getStatus();
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->status->getMessage();
    }

    /**
     * @return UserDocumentStatus
     */
    public function getUserDocumentStatus()
    {
        return $this->status;
    }

    /**
     * @return DisplayUserInfo
     */
    public function getDisplayUserInfo()
    {
        return $this->displayUserInfo;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->displayUserInfo->fullNameOrEmail;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->displayUserInfo->company;
    }

    public function getAgreementInfo()
    {
        return $this->agreement->get();
    }

}