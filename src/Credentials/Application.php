<?php namespace Echosign\Credentials;

use Echosign\Interfaces\CredentialInterface;

class Application implements CredentialInterface {

    protected $applicationSecret;
    protected $applicationId;

    public function __construct($applicationSecret, $applicationId)
    {
        $this->applicationSecret = $applicationSecret;
        $this->applicationId     = $applicationId;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'applicationSecret' => $this->applicationSecret,
            'applicationId'     => $this->applicationId,
        ];
    }


}