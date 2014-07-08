<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class UserCreationInfo implements InfoInterface {

    public $optin = 'NO';
    protected  $groupId;
    protected $lastName;
    public $title;
    public $phone;
    protected $email;
    public $company;
    public $customField1, $customField2, $customField3;
    protected $firstName;
    protected $password;

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @param $groupId
     */
    public function __construct( $firstName, $lastName, $email, $password, $groupId )
    {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
        $this->password  = $password;
        $this->groupId   = $groupId;
    }

    /**
     * @param mixed $email
     * @throws \RuntimeException
     */
    public function setEmail( $email )
    {
        if( empty($email) ) {
            throw new \RuntimeException('Email can not be empty');
        }

        if( ! filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            throw new \RuntimeException('invalid email address');
        }

        $this->email = filter_var( $email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * @return string
     */
    public function getGroupId()
    {
        return $this->groupId;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $firstName
     * @throws \RuntimeException
     */
    public function setFirstName( $firstName )
    {
        if( empty($firstName) ) {
            throw new \RuntimeException('firstName can not be empty');
        }
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     * @throws \RuntimeException
     */
    public function setLastName( $lastName )
    {
        if( empty($lastName) ) {
            throw new \RuntimeException('lastName can not be empty');
        }
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $password
     * @throws \RuntimeException
     */
    public function setPassword( $password )
    {
        if( empty($password) ) {
            throw new \RuntimeException('Password can not be empty');
        }
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'optin' => $this->optin,
            'groupid'=>$this->groupId,
            'lastName'=>$this->lastName,
            'title'=>$this->title,
            'phone'=>$this->phone,
            'email'=>$this->email,
            'company'=>$this->company,
            'customField1'=>$this->customField1,
            'customField2'=>$this->customField2,
            'customField3'=>$this->customField3,
            'firstName'=>$this->firstName,
            'password'=>$this->password,
        ]);
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}