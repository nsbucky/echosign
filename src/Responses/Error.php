<?php namespace Echosign\Responses;

class Error {

    protected $message;
    protected $code;
    protected $httpCode;

    /**
     * @param $httpCode
     * @param $code
     * @param $message
     */
    public function __construct($httpCode, $code, $message)
    {
        $this->code = $code;
        $this->message = $message;
        $this->httpCode = $httpCode;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return integer
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

}