<?php namespace Echosign\Responses;

use Echosign\Agreements\UserAgreement;

class UserAgreements {

    protected $userAgreementList = [];

    public function __construct( array $response )
    {
        foreach( $response['userAgreementList'] as $agreement ) {
            $this->userAgreementList[] = new UserAgreement( $agreement );            
        }
    }
}