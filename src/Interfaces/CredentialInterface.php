<?php namespace Echosign\Interfaces;

interface CredentialInterface {

    /**
     * @return string
     */
    public function toJson();

    /**
     * @return array
     */
    public function toArray();
}