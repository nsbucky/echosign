<?php namespace Echosign\Types;

class LibraryTemplateType {

    protected $type;

    protected $messages = [
        'DOCUMENT' => 'This library document belongs to a specific user',
        'FORM_FIELD_LAYER'=>'This library document is shared by another user in the group or account'
    ];

    public function __construct( $type )
    {
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