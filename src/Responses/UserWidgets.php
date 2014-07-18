<?php namespace Echosign\Responses;

use Echosign\Widget\UserWidget;

class UserWidgets {

    protected $userWidgetList = [];

    public function __construct( array $response )
    {
        foreach( $response['userWidgetList'] as $u ){
            $this->userWidgetList[] = new UserWidget(
                \Echosign\array_get($u, 'javascript'),
                \Echosign\array_get($u, 'modifiedDate'),
                \Echosign\array_get($u, 'name'),
                \Echosign\array_get($u, 'status'),
                \Echosign\array_get($u, 'url'),
                \Echosign\array_get($u, 'widgetId')
            );
        }
    }

    /**
     * @return array
     */
    public function getUserWidgetList()
    {
        return $this->userWidgetList;
    }


}