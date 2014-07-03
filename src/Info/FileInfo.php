<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class FileInfo implements InfoInterface {

    public $libraryDocumentId;
    public $transientDocumentId;
    public $libraryDocumentName;
    public $documentURL;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'libraryDocumentId'   => $this->libraryDocumentId,
            'transientDocumentId' => $this->transientDocumentId,
            'libraryDocumentName' => $this->libraryDocumentName,
            'documentURL'         => $this->documentURL
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