<?php namespace Echosign\Responses;

class ReminderCreationResult {

    public $result, $recipientEmail;

    function __construct( array $response )
    {
        $this->recipientEmail = $response['recipientEmail'];
        $this->result         = $response['result'];
    }


}