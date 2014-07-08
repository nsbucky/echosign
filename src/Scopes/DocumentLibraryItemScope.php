<?php namespace Echosign\Scopes;

class DocumentLibraryItemScope {

    protected $scope;

    protected $messages = [
        'SHARED' => 'This library document is shared by another user in the group or account',
        'GLOBAL'=>'This library document is available to all EchoSign users',
        'PERSONAL'=>'This library document belongs to a specific user',
    ];

    public function __construct( $scope )
    {
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