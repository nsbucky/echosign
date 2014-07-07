<?php namespace Echosign\Responses;

class TransientDocuments {
    /**
     * @var string
     */
    protected $transientDocumentId;

    /**
     * @param $transientDocumentId
     */
    public function __construct( array $response )
    {
        $this->transientDocumentId = $response['transientDocumentId'];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->transientDocumentId;
    }
}