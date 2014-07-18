<?php namespace Echosign\Info;

use Echosign\Interfaces\InfoInterface;

class WidgetFileInfo implements InfoInterface {

    public $libraryDocumentId;
    public $transientDocumentId;
    public $libraryDocumentName;

    /**
     * @var URLFileInfo
     */
    protected $documentURL;

    public function setDocumentURL($name, $url, $mimeType=null)
    {
        $this->documentURL = new URLFileInfo($name, $url, $mimeType);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $documentURL = null;

        if( isset( $this->documentURL ) ) {
            $documentURL = $this->documentURL->toArray();
        }

        return array_filter([
            'libraryDocumentId'   => $this->libraryDocumentId,
            'transientDocumentId' => $this->transientDocumentId,
            'libraryDocumentName' => $this->libraryDocumentName,
            'documentURL'         => $documentURL
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