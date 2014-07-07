<?php namespace Echosign\Credentials;

use Echosign\Interfaces\CredentialInterface;

class Reminder implements CredentialInterface {

    protected $agreementId;
    protected $comment;

    public function __construct( $agreementId, $comment )
    {
        $this->agreementId = $agreementId;
        $this->comment     = $comment;
    }

    /**
     * @return string
     */
    public function getAgreementId()
    {
        return $this->agreementId;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
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
            'agreementId' => $this->agreementId,
            'comment'     => $this->comment
        ];
    }


}