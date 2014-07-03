<?php namespace Echosign\Interfaces;

interface TransportInterface {

    public function get( RequestEntityInterface $entity );
    public function post( RequestEntityInterface $entity );
    public function put( RequestEntityInterface $entity );
    public function delete( RequestEntityInterface $entity );

}