<?php namespace Echosign\Responses;

use Echosign\Agreement;
use Echosign\Documents\Document;
use Echosign\Documents\SupportingDocument;

class AgreementDocuments {

    protected $supportingDocuments = [];
    protected $documents = [];
    protected $agreement;
    protected $agreementId;

    /**
     * @param array $response
     * @param Agreement $agreement
     * @param $agreementId
     */
    public function __construct( array $response, Agreement $agreement, $agreementId )
    {
        $this->agreement = $agreement;

        if( array_key_exists( 'supportingDocuments', $response )) {
            foreach( $response['supportingDocuments'] as $sd ) {
                $this->supportingDocuments[] = new SupportingDocument( $sd, $this );
            }
        }

        if( array_key_exists( 'documents', $response )) {
            foreach( $response['documents'] as $d ) {
                $this->documents[] = new Document( $d, $this );
            }
        }
    }

    /**
     * @return Agreement
     */
    public function getAgreement()
    {
        return $this->agreement;
    }

    /**
     * @return array|Document[]
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return array|SupportingDocument[]
     */
    public function getSupportingDocuments()
    {
        return $this->supportingDocuments;
    }

    /**
     * @return string
     */
    public function getAgreementId()
    {
        return $this->agreementId;
    }
}