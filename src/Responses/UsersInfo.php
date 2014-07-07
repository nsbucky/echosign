<?php namespace Echosign\Responses;

use Echosign\Info\UserInfo;

class UsersInfo {

    protected $userInfoList = [];

    function __construct( array $response )
    {
        foreach($response['userInfoList'] as $user ) {
            $this->userInfoList[] = new UserInfo( $user['company'], $user['email'], $user['fullNameOrEmail'], $user['groupId'], $user['userId']);
        }
    }

    /**
     * @return array
     */
    public function getUserInfoList()
    {
        return $this->userInfoList;
    }


}