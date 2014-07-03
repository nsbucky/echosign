<?php namespace Echosign\Interfaces;

interface InfoInterface {

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function toJson();
}