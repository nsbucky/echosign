<?php namespace Echosign\Status;

class UserDocumentStatus {
    
    protected $status;    
    
    protected $statusMessages = [
        'EXPIRED' => 'The document has expired',
        'SIGNED' => 'The document has been completed',
        'WAITING_FOR_MY_APPROVAL' => 'It is the current user\'s turn to approve the document',
        'OUT_FOR_SIGNATURE' => 'It is another user\'s turn to sign the document',
        'ARCHIVED' => 'The document has been archived in the user\'s account',
        'APPROVED' => 'The document has been approved',
        'WAITING_FOR_MY_SIGNATURE' => ' It is the current user\'s turn to sign the document,',
        'WAITING_FOR_AUTHORING' => 'The document is waiting to be authored',
        'WIDGET' => 'The document is a widget',
        'OUT_FOR_APPROVAL' => 'It is another user\'s turn to approve the document,',
        'RECALLED' => 'The document was recalled before completion',
        'FORM' => 'The document is a form that can be used to create new documents',
        'WAITING_FOR_FAXIN' => 'The current user needs to fax in the original document',
    ];

    /**
     * @param $status
     * @throws \InvalidArgumentException
     */
    public function __construct( $status )
    {
        if( ! array_key_exists( $status, $this->statusMessages ) ) {
            throw new \InvalidArgumentException("Invalid status set for ". __CLASS__);
        }
        $this->status = $status;
    }
    
    public function getMessage()
    {
        return $this->statusMessages[ $this->status ];
    }
    
    public function getStatus()
    {
        return $this->status;
    }
}