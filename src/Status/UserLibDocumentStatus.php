<?php namespace Echosign\Status;

class UserLibDocumentStatus {
    
    protected $status;

    protected $statusMessages = [
        'EXPIRED'                  => 'The document has expired',
        'SIGNED'                   => 'The document has been signed and filed',
        'WAITING_FOR_MY_APPROVAL'  => 'The document is waiting for the current participant to approve',
        'OTHER'                    => 'In the future, statuses other than those above may be added to the EchoSign application. For backward compatibility reasons, existing API clients will receive status OTHER. You may need to update your client application to the latest version of the API to receive the new statuses in those cases',
        'OUT_FOR_SIGNATURE'        => 'The document is out for signature',
        'ARCHIVED'                 => 'The document has been archived',
        'UNKNOWN'                  => 'The current status of the document is unknown',
        'APPROVED'                 => 'The document has been approved',
        'HIDDEN'                   => 'The document is currently hidden',
        'WAITING_FOR_AUTHORING'    => 'The document is waiting to be authored',
        'WAITING_FOR_MY_SIGNATURE' => 'The document is waiting for the current participant to sign',
        'WIDGET'                   => 'The document is a widget',
        'OUT_FOR_APPROVAL'         => 'The document out for approval',
        'RECALLED'                 => 'The document has been recalled by the sender',
        'FORM'                     => 'The document is a form',
        'NOT_YET_VISIBLE'          => 'The document is not yet visible to the current participant',
        'IN_REVIEW'                => 'The document is in the review process',
        'WAITING_FOR_MY_REVIEW'    => 'The document is waiting for the current participant to review',
        'PARTIAL'                  => 'The document is incomplete',
        'WAITING_FOR_FAXIN'        => 'The document is waiting for the signature to be faxed-in'
    ];

    public function __construct( $status )
    {
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