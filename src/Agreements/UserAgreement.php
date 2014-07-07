<?php namespace Echosign\Agreements;

use Echosign\Info\DisplayUserInfo;
use Echosign\Status\UserDocumentStatus;

class UserAgreement {

    public $displayDate;
    protected $status;
    protected $displayUserInfo;
    public $agreementId;
    public $esign;
    public $lastestVersionId;

    public function __construct( array $agreement )
    {
        $this->displayDate = $agreement['displayDate'];
        $this->setStatus( new UserDocumentStatus( $agreement['status']) );
        $this->name = $agreement['name'];
        $this->setUserInfo( new DisplayUserInfo( $agreement['displayUserInfo'] ) );
        $this->agreementId = $agreement['agreementId'];
        $this->esign = $agreement['esign'];
        $this->lastestVersionId = $agreement['latestVersionId'];
    }

    public function setStatus( UserDocumentStatus $status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setUserInfo( DisplayUserInfo $info )
    {
        $this->displayUserInfo = $info;
    }

    public function getUserInfo()
    {
        return $this->displayUserInfo;
    }

}