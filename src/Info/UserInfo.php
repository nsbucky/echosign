<?php namespace Echosign\Info;

class UserInfo {

    protected $groupId, $email, $userId, $company, $fullNameOrEmail;

    function __construct( $company, $email, $fullNameOrEmail, $groupId, $userId )
    {
        $this->company         = $company;
        $this->email           = $email;
        $this->fullNameOrEmail = $fullNameOrEmail;
        $this->groupId         = $groupId;
        $this->userId          = $userId;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getFullNameOrEmail()
    {
        return $this->fullNameOrEmail;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }


}