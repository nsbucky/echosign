<?php namespace Echosign\Interfaces;

interface RequestEntityInterface {

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function toJson();

    /**
     * @return string
     */
    public function getEndPoint();

    public function setTransport(TransportInterface $transport);

    public function getTransport();

    public function getAccessToken();

    public function getHeaders();

    public function getBody();

}