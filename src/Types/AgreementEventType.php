<?php namespace Echosign\Types;

class AgreementEventType {

    protected $status;

    protected $messages = [
        'DOCUMENTS_DELETED'                 => 'Document retention applied - all documents deleted',
        'SHARED'                            => 'The document has been shared by a participant',
        'EMAIL_BOUNCED'                     => 'The Email sent to a signer bounced and was not delivered',
        'SIGNER_SUGGESTED_CHANGES'          => 'Changes have been suggested by the signer on the document',
        'SIGNED'                            => 'The document has been signed',
        'OTHER'                             => 'In the future, statuses other than those above may be added to the EchoSign application. For backward compatibility reasons, existing API clients receive status OTHER. You may need to update your client application to the latest version of the API to receive the new statuses in those cases',
        'APPROVED'                          => 'The document has been approved',
        'EXPIRED_AUTOMATICALLY'             => 'The document automatically expired',
        'VAULTED'                           => 'Document was vaulted',
        'APPROVAL_REQUESTED'                => 'The document has been sent out for approval',
        'DELEGATED'                         => 'The document has been delegated by the signer',
        'ESIGNED'                           => 'The document has been eSigned',
        'AUTO_CANCELLED_CONVERSION_PROBLEM' => 'The document has been cancelled because of problems with processing',
        'FAXED_BY_SENDER'                   => 'The document has been faxed in by the sender on behalf of the signer',
        'PASSWORD_AUTHENTICATION_FAILED'    => 'Signer failed all password authentication attempts',
        'KBA_AUTHENTICATED'                 => 'Signer successfully verified identity using Knowledge Based Authentication',
        'EXPIRED'                           => 'The document has expired',
        'REJECTED'                          => 'The document has been rejected by the signer',
        'SIGNATURE_REQUESTED'               => 'The document has been sent out for signatures',
        'WEB_IDENTITY_AUTHENTICATED'        => 'Signer provided web identity before viewing the document',
        'UPLOADED_BY_SENDER'                => 'The document has been uploaded by sender',
        'WEB_IDENTITY_SPECIFIED'            => 'Signer provided web identity after viewing the document',
        'WIDGET_DISABLED'                   => 'The widget was disabled',
        'CREATED'                           => 'The document has been created',
        'OFFLINE_SYNC'                      => 'Offline events have been synchronized and recorded',
        'REPLACED_SIGNER'                   => 'Signer was replaced by the sender',
        'WIDGET_ENABLED'                    => 'The widget was enabled',
        'RECALLED'                          => 'The document has been cancelled by the sender',
        'EMAIL_VIEWED'                      => 'The document has been viewed',
        'FAXIN_RECEIVED'                    => 'The faxed-in signature has been received',
        'SENDER_CREATED_NEW_REVISION'       => 'A new revision of the document has been created',
        'KBA_AUTHENTICATION_FAILED'         => 'Signer failed all Knowledge Based Authentication authentication attempts'
    ];

    /**
     * @param $status
     * @throws \InvalidArgumentException
     */
    public function __construct( $status )
    {
        if( ! in_array( $status, $this->statusMessages ) ) {
            throw new \InvalidArgumentException("Invalid status set for ". __CLASS__);
        }
        $this->status = $status;
    }

    public function getMessage()
    {
        return $this->messages[ $this->status ];
    }

    public function getStatus()
    {
        return $this->status;
    }
}