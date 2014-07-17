<?php namespace Echosign\Options;

class LibDocParticipantInfoSecurityOption {

    protected $messages = [
        'OTHER'        => 'In the future, statuses other than those above may be added to the EchoSign application. For backward compatibility reasons, existing API clients will receive status OTHER. You may need to update your client application to the latest version of the API to receive the new statuses in those cases',
        'KBA'          => 'The participant must pass Knowledge Based Authentication to view and sign the document',
        'WEB_IDENTITY' => 'The participant must provide a web identity to view and sign the document',
        'PASSWORD'     => 'The participant must enter a password to view and sign the document'
    ];

    /**
     * @param $status
     * @throws \InvalidArgumentException
     */
    public function __construct( $status )
    {
        if( ! in_array( $status, $this->messages ) ) {
            throw new \InvalidArgumentException("Invalid status set for ". __CLASS__);
        }

        $this->status = $status;
    }

    public function getMessage()
    {
        return $this->mssages[ $this->status ];
    }

    public function getStatus()
    {
        return $this->status;
    }
}