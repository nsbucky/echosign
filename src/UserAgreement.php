<?php namespace Echosign;

use Echosign\Info\DisplayUserInfo;
use Echosign\Status\UserDocumentStatus;

class UserAgreement {

    public $displayDate;
    protected $status;
    protected $displayUserInfo;
    public $agreementId;
    public $esign;
    public $lastestVersionId;

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