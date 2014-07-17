<?php namespace Echosign\Roles;

class ParticipantRole {

    protected $role;

    protected $descriptions = [
        'SENDER'   => 'Sender or originator of the document',
        'SHARE'    => 'Participant with whom the document has been shared',
        'OTHER'    => 'In the future, roles other than those above may be added to the EchoSign application. For backward compatibility reasons, existing API clients will receive role OTHER. You may need to update your client application to the latest version of the API to receive the new roles in those cases',
        'CC'       => 'Participant that is bound to the document as an observer, by the sender',
        'SIGNER'   => 'Signer of the document',
        'APPROVER' => 'Approver of the document',
        'DELEGATE' => 'Participant that is delegated to sign the document, by the signer'
    ];

    /**
     * @param $role
     * @throws \InvalidArgumentException
     */
    public function __construct( $role )
    {
        if( ! array_key_exists( $role, $this->descriptions ) ) {
            throw new \InvalidArgumentException("Invalid role set for ". __CLASS__);
        }

        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->descriptions[ $this->role ];
    }

    /**
     * @return bool
     */
    public function isDelegated()
    {
        return $this->role === 'DELEGATE';
    }

    /**
     * @return bool
     */
    public function isSharedWith()
    {
        return $this->role === 'SHARE';
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return bool
     */
    public function isSender()
    {
        return $this->role === 'SENDER';
    }

    /**
     * @return bool
     */
    public function isSigner()
    {
        return $this->role === 'SIGNER';
    }

    /**
     * @return bool
     */
    public function canApprove()
    {
        return $this->role === 'APPROVER';
    }

    /**
     * @return bool
     */
    public function isObserver()
    {
        return $this->role === 'CC';
    }
}