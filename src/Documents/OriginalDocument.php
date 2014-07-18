<?php namespace Echosign\Documents;

use Echosign\Responses\Documents;

class OriginalDocument {

    protected $name, $documentId, $mimeType;
    /**
     * @var \Echosign\Responses\Documents
     */
    protected $documents;

    public function __construct( array $config, Documents $documents  )
    {
        foreach(['name','documentId','mimeType'] as $c) {
            $this->$c = \Echosign\array_get( $config, $c);
        }

        $this->documents = $documents;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->documentId;
    }

    /**
     * @param string $savePath
     * @param $fileName
     * @return string|boolean if successful the saved path to the file or false if it fails
     */
    public function downloadDocument($savePath, $fileName)
    {
        $library = $this->documents->getLibraryDocument();

        $file = $library->document( $this->documents->getLibraryDocumentId(), $this->getId(), $fileName );

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