<?php namespace Echosign\Types;

class LibraryTemplateType {

    protected $type;

    protected $messages = [
        'DOCUMENT' => 'This library document belongs to a specific user',
        'FORM_FIELD_LAYER'=>'This library document is shared by another user in the group or account'
    ];

    /**
     * @param $type
     * @throws \InvalidArgumentException
     */
    public function __construct( $type )
    {
        if( ! array_key_exists( $type, $this->messages ) ) {
            throw new \InvalidArgumentException("Invalid type set for ". __CLASS__);
        }
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->messages[ $this->type ];
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}