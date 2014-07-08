<?php namespace Echosign\Documents;

use Echosign\Responses\Documents;

class LibDocSupportingDocument {

    protected $displayLabel, $supportingDocumentId, $fieldName, $mimeType;
    protected $document;

    /**
     * @param array $config
     * @param Documents $document
     */
    public function __construct( array $config, Documents $document )
    {
        foreach(['displayLabel', 'supportingDocumentId', 'mimeType'] as $c) {
            $this->$c = \Echosign\array_get( $config, $c);
        }

        $this->document = $document;

        // there might a screw up with adobes docs. so this is why this is here.
        if( array_key_exists('fieldName', $config)) {
            $this->fieldName = $config['fieldName'];
        }

        if( array_key_exists('fieldname', $config)) {
            $this->fieldName = $config['fieldname'];
        }
    }

    /**
     * @return string
     */
    public function getDisplayLabel()
    {
        return $this->displayLabel;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->supportingDocumentId;
    }

    /**
     * @param string $savePath
     * @return string|boolean if successful the saved path to the file or false if it fails
     */
    public function downloadDocument($savePath)
    {
        $library = $this->document->getLibraryDocument();

        $file = $library->document( $this->documents->getLibraryDocumentId(), $this->getId() );

        if( false === $file ) {
            return false;
        }

        $newName = $savePath . DIRECTORY_SEPARATOR . $this->name;

        if( rename( $file, $newName) ) {
            return $newName;
        }

        return false;
    }
}