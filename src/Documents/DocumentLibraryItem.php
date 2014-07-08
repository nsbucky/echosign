<?php namespace Echosign\Documents;

use Echosign\LibraryDocument;
use Echosign\Scopes\DocumentLibraryItemScope;
use Echosign\Types\LibraryTemplateType;

class DocumentLibraryItem {

    protected $libraryTemplateTypes = [];
    protected $scope;
    /**
     * @var LibraryDocument
     */
    protected $libraryDocument;
    public $libraryDocumentId;
    public $modifiedDate;
    public $name;

    /**
     * @param LibraryDocument $libraryDocument
     * @param $libraryDocumentId
     * @param $libraryTemplateTypes
     * @param $modifiedDate
     * @param $name
     * @param $scope
     */
    function __construct(LibraryDocument $libraryDocument, $libraryDocumentId, array $libraryTemplateTypes, $modifiedDate, $name, $scope )
    {
        $this->libraryDocument      = $libraryDocument;
        $this->libraryDocumentId    = $libraryDocumentId;

        foreach( $libraryTemplateTypes as $type ) {
            $this->libraryTemplateTypes[] = new LibraryTemplateType($type);
        }

        $this->modifiedDate         = \DateTime::createFromFormat(\DateTime::W3C, $modifiedDate);
        $this->name                 = $name;
        $this->scope                = new DocumentLibraryItemScope($scope);
    }

    /**
     * @return \Echosign\LibraryDocument
     */
    public function getLibraryDocument()
    {
        return $this->libraryDocument;
    }


    /**
     * @return mixed
     */
    public function getLibraryDocumentId()
    {
        return $this->libraryDocumentId;
    }

    /**
     * @return array|LibraryTemplateType[]
     */
    public function getLibraryTemplateTypes()
    {
        return $this->libraryTemplateTypes;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return DocumentLibraryItemScope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @return \Echosign\Responses\LibraryDocumentInfo
     */
    public function getInfo()
    {
        return $this->getLibraryDocument()->getInfo( $this->getLibraryDocumentId() );
    }

}