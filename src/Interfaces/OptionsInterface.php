<?php namespace Echosign\Interfaces;

interface OptionsInterface {

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return string
     */
    public function toJson();
}