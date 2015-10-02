<?php

namespace Tiny\Http;


/**
 * Class Request
 * @package Tiny\Http
 */
class Request {
    private $redirectStatus;
    private $httpHost;
    private $httpUserAgent;
    private $httpAccept;
    private $httpAcceptLanguage;
    private $httpAcceptEncoding;
    private $httpConnection;
    private $httpCacheControl;
    private $requestMethod;

    /**
     * @return mixed
     */
    public function getHttpAcceptLanguage(){
        return $this->httpAcceptLanguage;
    }

    /**
     * @param mixed $httpAcceptLanguage
     */
    public function setHttpAcceptLanguage($httpAcceptLanguage){
        $this->httpAcceptLanguage = $httpAcceptLanguage;
    }

    /**
     * @return mixed
     */
    public function getHttpAccept(){
        return $this->httpAccept;
    }

    /**
     * @param mixed $httpAccept
     */
    public function setHttpAccept($httpAccept){
        $this->httpAccept = $httpAccept;
    }

    /**
     * @return mixed
     */
    public function getHttpAcceptEncoding(){
        return $this->httpAcceptEncoding;
    }

    /**
     * @param mixed $httpAcceptEncoding
     */
    public function setHttpAcceptEncoding($httpAcceptEncoding){
        $this->httpAcceptEncoding = $httpAcceptEncoding;
    }

    /**
     * @return mixed
     */
    public function getHttpCacheControl(){
        return $this->httpCacheControl;
    }

    /**
     * @param mixed $httpCacheControl
     */
    public function setHttpCacheControl($httpCacheControl){
        $this->httpCacheControl = $httpCacheControl;
    }

    /**
     * @return mixed
     */
    public function getHttpConnection(){
        return $this->httpConnection;
    }

    /**
     * @param mixed $httpConnection
     */
    public function setHttpConnection($httpConnection){
        $this->httpConnection = $httpConnection;
    }

    /**
     * @return mixed
     */
    public function getHttpHost(){
        return $this->httpHost;
    }

    /**
     * @param mixed $httpHost
     */
    public function setHttpHost($httpHost){
        $this->httpHost = $httpHost;
    }

    /**
     * @return mixed
     */
    public function getHttpUserAgent(){
        return $this->httpUserAgent;
    }

    /**
     * @param mixed $httpUserAgent
     */
    public function setHttpUserAgent($httpUserAgent){
        $this->httpUserAgent = $httpUserAgent;
    }

    /**
     * @return mixed
     */
    public function getRedirectStatus(){
        return $this->redirectStatus;
    }

    /**
     * @param mixed $redirectStatus
     */
    public function setRedirectStatus($redirectStatus){
        $this->redirectStatus = $redirectStatus;
    }

    /**
     * @return mixed
     */
    public function getRequestMethod(){
        return $this->requestMethod;
    }

    /**
     * @param mixed $requestMethod
     */
    public function setRequestMethod($requestMethod){
        $this->requestMethod = $requestMethod;
    }

} 