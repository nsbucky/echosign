<?php namespace Echosign\Responses;

use Echosign\Agreement;
use Echosign\Agreements\UserAgreement;

class UserAgreements {

    protected $userAgreementList = [];
    protected $agreement;
    /**
     * @param array $response
     * @param Agreement $agreement
     */
    public function __construct( array $response, Agreement $agreement )
    {
        foreach( $response['userAgreementList'] as $u ) {
            $this->userAgreementList[] = new UserAgreement( $u, $agreement );
        }

        $this->agreement = $agreement;
    }

    /**
     * @return UserAgreement[]
     */
    public function getAgreements()
    {
        return $this->userAgreementList;
    }
}