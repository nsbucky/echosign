<?php namespace Echosign\Options;

class DocSecurityOption {

    protected $option;
    protected $optionMessages = [
        'OTHER'=>'In the future, options other than those above may be added to the EchoSign application. For backward compatibility reasons, existing API clients will receive the option, OTHER. You may need to update your client application to the latest version of the API to receive the new options',
        'OPEN_PROTECTED'=>'A password is required to open the document'
    ];

    public function __construct( $option )
    {
        $this->option = $option;
    }

    public function getMessage()
    {
        return $this->optionMessages[ $this->option ];
    }

    public function getOption()
    {
        return $this->option;
    }
}