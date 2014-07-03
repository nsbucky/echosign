<?php namespace Echosign\Transports;

use Echosign\Responses\Error;
use Echosign\Interfaces\RequestEntityInterface;
use Echosign\Interfaces\TransportInterface;

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

        if( $response->getStatusCode() > 200 ) {
            // oops an erro with the response
            return new Error( $json['code'], $json['message'] );
        }

        return $json;
    }

    public function get( RequestEntityInterface $entity )
    {
        $response = $this->client->get($this->buildUrl($entity),[
                'headers' => $entity->getHeaders(),
                'body' => $entity->getBody()
            ]
        );

        return $this->handleResponse( $response );
    }

    public function post( RequestEntityInterface $entity )
    {
        $response = $this->client->post($this->buildUrl($entity),[
                'headers' => $entity->getHeaders(),
                'body' => $entity->getBody()
            ]
        );

        return $this->handleResponse( $response );
    }

    public function put( RequestEntityInterface $entity )
    {
        $response = $this->client->put($this->buildUrl($entity),[
                'headers' => $entity->getHeaders(),
                'body' => $entity->getBody()
            ]
        );

        return $this->handleResponse( $response );
    }

    public function delete( RequestEntityInterface $entity )
    {
        $response = $this->client->delete($this->buildUrl($entity),[
                'headers' => $entity->getHeaders(),
                'body' => $entity->getBody()
            ]
        );

        return $this->handleResponse( $response );
    }

}