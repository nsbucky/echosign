<?php namespace Echosign\Responses;

class UserCreationResponse {

    protected $userId;

    public function __construct( array $response )
    {
        if( isset( $response['userId'] ) ) {
            $this->userId = $response['userId'];
        }
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId( $userId )
    {
        $this->userId = $userId;
    }

}