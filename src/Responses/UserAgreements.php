<?php namespace Echosign\Responses;

use Echosign\Info\DisplayUserInfo;
use Echosign\Status\UserDocumentStatus;
use Echosign\UserAgreement;

class UserAgreements {

    protected $userAgreementList = [];

    public function __construct( array $userAgreements )
    {
        foreach( $userAgreements as $agreement ) {
            $ua = new UserAgreement();
            $ua->displayDate = $agreement['displayDate'];
            $ua->setStatus( new UserDocumentStatus( $agreement['status']) );
            $ua->name = $agreement['name'];
            $ua->setUserInfo( new DisplayUserInfo( $agreement['displayUserInfo'] ) );
            $ua->agreementId = $agreement['agreementId'];
            $ua->esign = $agreement['esign'];
            $ua->lastestVersionId = $agreement['latestVersionId'];
            $userAgreements[] = $ua;
        }
    }
}