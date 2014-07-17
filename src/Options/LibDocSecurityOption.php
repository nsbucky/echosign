<?php namespace Echosign\Options;

class LibDocSecurityOption {

    protected $option;
    protected $optionMessages = [
        'OTHER'=>'In the future, options other than those above may be added to the EchoSign application. For backward compatibility reasons, existing API clients will receive the option, OTHER. You may need to update your client application to the latest version of the API to receive the new options',
        'OPEN_PROTECTED'=>'A password is required to open the document'
    ];

    /**
     * @param $option
     * @throws \InvalidArgumentException
     */
    public function __construct( $option )
    {
        if( ! in_array( $option, $this->optionMessages ) ) {
            throw new \InvalidArgumentException("Invalid option set for ". __CLASS__);
        }
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