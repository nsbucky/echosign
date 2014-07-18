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

    /**
     * @param TransportInterface $transport
     */
    public function setTransport(TransportInterface $transport);

    /**
     * @return TransportInterface
     */
    public function getTransport();

    /**
     * @return string
     */
    public function getAccessToken();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @return string
     */
    public function getSaveTo();

}