<?php namespace Echosign\Responses;

use Echosign\Documents\DocumentLibraryItem;
use Echosign\LibraryDocument;

class DocumentLibraryItems {

    protected $libraryDocumentsList = [];
    protected $libraryDocument;

    function __construct( array $response, LibraryDocument $libraryDocument )
    {
        foreach( $response['libraryDocumentList'] as $doc ) {
            $this->libraryDocumentsList[] = new DocumentLibraryItem($libraryDocument, $doc['libraryDocumentId'], $doc['libraryTemplateTypes'], $doc['modifiedDate'], $doc['name'], $doc['scope']);
        }

        $this->libraryDocument = $libraryDocument;
    }

    /**
     * @return \Echosign\LibraryDocument
     */
    public function getLibraryDocument()
    {
        return $this->libraryDocument;
    }


    /**
     * @return array|DocumentLibraryItem[]
     */
    public function getLibraryDocuments()
    {
        return $this->libraryDocumentsList;
    }


}