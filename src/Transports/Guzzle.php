<?php namespace Echosign\Transports;

use Echosign\Responses\Error;
use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;
use GuzzleHttp\Exception\ClientException;

class Guzzle implements TransportInterface {

    /**
     * @var \GuzzleHttp\Client;
     */
    protected $client;
    protected $baseUrl = 'https://secure.echosign.com/api/rest/v2';

    public function __construct($baseUrl = null )
    {
        if( null !== $baseUrl ) {
            $this->baseUrl = $baseUrl;
        }

        $this->client = new \GuzzleHttp\Client();
    }

    public function buildUrl( RequestEntityInterface $entity )
    {
        return $this->baseUrl . $entity->getEndPoint();
    }

    protected function handleResponse( $response )
    {
        $json = $response->json();

        if( $response->getStatusCode() > 400 ) {
            // oops an erro with the response
            return new Error( $json['code'], $json['message'] );
        }

        return $json;
    }

    public function get( RequestEntityInterface $entity )
    {
        try {
            $response = $this->client->get($this->buildUrl($entity),[
                    'headers' => $entity->getHeaders(),
                    'body' => $entity->getBody()
                ]
            );
        } catch( ClientException $e ) {
            $response = $e->getResponse();
        }

        return $this->handleResponse( $response );
    }

    public function post( RequestEntityInterface $entity )
    {
        try {
            $response = $this->client->post($this->buildUrl($entity),[
                    'headers' => $entity->getHeaders(),
                    'body' => $entity->getBody()
                ]
            );
        } catch( ClientException $e ) {
            $response = $e->getResponse();
        }

        return $this->handleResponse( $response );
    }

    public function put( RequestEntityInterface $entity )
    {
        try {
            $response = $this->client->put($this->buildUrl($entity),[
                    'headers' => $entity->getHeaders(),
                    'body' => $entity->getBody()
                ]
            );
        } catch( ClientException $e ) {
            $response = $e->getResponse();
        }

        return $this->handleResponse( $response );
    }

    public function delete( RequestEntityInterface $entity )
    {
        try {
            $response = $this->client->delete($this->buildUrl($entity),[
                    'headers' => $entity->getHeaders(),
                    'body' => $entity->getBody()
                ]
            );
        } catch( ClientException $e ) {
            $response = $e->getResponse();
        }

        return $this->handleResponse( $response );
    }

}