<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;
use Echosign\Options\InteractiveOptions;

class AgreementCreationInfo implements InfoInterface {

    protected $documentCreationInfo;
    protected $interactiveOptions;

    public function __construct( DocumentCreationInfo $documentCreationInfo, InteractiveOptions $interactiveOptions )
    {
        $this->documentCreationInfo = $documentCreationInfo;
        $this->interactiveOptions   = $interactiveOptions;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'documentCreationInfo' => $this->documentCreationInfo->toArray(),
            'interactiveOptions'   => $this->interactiveOptions->toArray(),
        ];
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}