<?php namespace Echosign\Responses;

use Echosign\Agreement;
use Echosign\Agreements\UserAgreement;
use Echosign\Widget;

class WidgetAgreements {

    protected $userAgreementList = [];
    protected $widget;
    /**
     * @param array $response
     * @param Widget $widget
     */
    public function __construct( array $response, Widget $widget )
    {
        foreach( $response['userAgreementList'] as $u ) {
            $this->userAgreementList[] = new UserAgreement( $u, $widget );
        }

        $this->widget = $widget;
    }

    /**
     * @return UserAgreement[]
     */
    public function getAgreements()
    {
        return $this->userAgreementList;
    }
}