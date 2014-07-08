<?php namespace Echosign\Responses;

use Echosign\Documents\LibDocSupportingDocument;
use Echosign\LibraryDocument;
use Echosign\Documents\OriginalDocument;

class Documents {

    protected $supportingDocuments = [];
    protected $documents = [];
    protected $libraryDocument;
    protected $libraryDocumentId;

    public function __construct( array $response, LibraryDocument $libraryDocument, $libraryDocumentId )
    {
        $this->libraryDocument = $libraryDocument;
        $this->libraryDocumentId = $libraryDocumentId;

        if( array_key_exists( 'supportingDocuments', $response )) {
            foreach( $response['supportingDocuments'] as $sdoc ) {
                $this->supportingDocuments[] = new LibDocSupportingDocument( $sdoc, $this );
            }
        }

        if( array_key_exists( 'documents', $response )) {
            foreach( $response['documents'] as $doc ) {
                $this->documents[] = new OriginalDocument( $doc, $this );
            }
        }
    }

    /**
     * @return array|OriginalDocument[]
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return \Echosign\LibraryDocument
     */
    public function getLibraryDocument()
    {
        return $this->libraryDocument;
    }

    /**
     * @return string
     */
    public function getLibraryDocumentId()
    {
        return $this->libraryDocumentId;
    }

    /**
     * @return array|LibDocSupportingDocument[]
     */
    public function getSupportingDocuments()
    {
        return $this->supportingDocuments;
    }


}