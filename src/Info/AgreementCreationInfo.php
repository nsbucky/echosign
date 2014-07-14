<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;
use Echosign\Options\InteractiveOptions;

class AgreementCreationInfo implements InfoInterface {

    protected $documentCreationInfo;
    protected $interactiveOptions;

    public function __construct( DocumentCreationInfo $documentCreationInfo, InteractiveOptions $interactiveOptions = null )
    {
        $this->documentCreationInfo = $documentCreationInfo;
        $this->interactiveOptions   = $interactiveOptions;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'documentCreationInfo' => $this->documentCreationInfo->toArray(),
            'options'              => $this->interactiveOptions instanceof InteractiveOptions
                                        ? $this->interactiveOptions->toArray()
                                        : null,
        ]);
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode( $this->toArray() );
    }


}