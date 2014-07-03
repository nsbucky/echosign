<?php namespace Echosign\Responses;

class TransientDocuments {
    /**
     * @var string
     */
    protected $transientDocumentId;

    /**
     * @param $transientDocumentId
     */
    public function __construct( $transientDocumentId )
    {
        $this->transientDocumentId = $transientDocumentId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->transientDocumentId;
    }
}