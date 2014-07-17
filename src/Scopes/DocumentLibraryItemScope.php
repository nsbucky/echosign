<?php namespace Echosign\Scopes;

class DocumentLibraryItemScope {

    protected $scope;

    protected $messages = [
        'SHARED' => 'This library document is shared by another user in the group or account',
        'GLOBAL'=>'This library document is available to all EchoSign users',
        'PERSONAL'=>'This library document belongs to a specific user',
    ];

    /**
     * @param $scope
     * @throws \InvalidArgumentException
     */
    public function __construct( $scope )
    {
        if( ! in_array( $scope, $this->messages ) ) {
            throw new \InvalidArgumentException("Invalid scope set for ". __CLASS__);
        }

        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->messages[ $this->scope ];
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }
}