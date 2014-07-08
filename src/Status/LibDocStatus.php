<?php namespace Echosign\Status;

class LibDocStatus {

    protected $status;

    protected $statusMessages = [
        'ABORTED'                         => 'The signature workflow has been cancelled by either the sender or the recipient. This is a terminal state',
        'EXPIRED'                         => 'The document has passed the expiration date and can no longer be signed. This is a terminal state',
        'SIGNED'                          => 'The document has been signed by all the requested parties. This is a terminal state',
        'OTHER'                           => 'In the future, statuses other than those above may be added to the EchoSign application. For backward compatibility reasons, existing API clients will receive status OTHER. You may need to update your client application to the latest version of the API to receive the new statuses in those cases',
        'DOCUMENT_LIBRARY'                => 'The status for agreements that are in the user\'s document library. This is a terminal state',
        'OUT_FOR_SIGNATURE'               => 'The document is currently waiting for one or more parties to sign it',
        'ARCHIVED'                        => 'The document uploaded by the user into their document archive. This is a terminal state',
        'WIDGET_WAITING_FOR_VERIFICATION' => 'The widget is currently waiting to be verified',
        'APPROVED'                        => 'The document has been approved by all requested parties. If document has both signers and approvers, terminal status will be signed',
        'WIDGET'                          => 'The status for the user\'s widgets. This is a terminal state',
        'AUTHORING'                       => 'The document is waiting for the sender to position fields before it can be sent for signature',
        'PREFILL'                         => 'The document is waiting for the sender to fill out fields before it can be sent for signature',
        'OUT_FOR_APPROVAL'                => 'The document is currently waiting to be approved',
        'WAITING_FOR_REVIEW'              => 'The document is currently waiting to be reviewed',
        'WAITING_FOR_PAYMENT'             => 'The document is waiting for payment in order to proceed',
        'WAITING_FOR_VERIFICATION'        => 'The document is currently waiting to be verified',
        'WAITING_FOR_FAXIN'               => 'The document is waiting for the sender to fax in the document contents before it can be sent for signature'
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