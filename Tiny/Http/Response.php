<?php

namespace Tiny\Http;


/**
 * Class Response
 * @package Tiny\Http
 */
class Response {
    private $contentEncoding;
    private $contentLanguage;
    private $contentLength;
    private $contentType;
    private $date;
    private $expires;
    private $location;
    private $server;
    private $body;
    private $transfertEncoding;
    private $status;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTransfertEncoding()
    {
        return $this->transfertEncoding;
    }

    /**
     * @param mixed $transfertEncoding
     */
    public function setTransfertEncoding($transfertEncoding)
    {
        $this->transfertEncoding = $transfertEncoding;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $Date
     */
    public function setDate($Date)
    {
        $this->date = $Date;
    }

    /**
     * @return mixed
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param mixed $Expires
     */
    public function setExpires($Expires)
    {
        $this->expires = $Expires;
    }

    /**
     * @return mixed
     */
    public function getContentEncoding()
    {
        return $this->contentEncoding;
    }

    /**
     * @param mixed $contentEncoding
     */
    public function setContentEncoding($contentEncoding)
    {
        $this->contentEncoding = $contentEncoding;
    }

    /**
     * @return mixed
     */
    public function getContentLanguage()
    {
        return $this->contentLanguage;
    }

    /**
     * @param mixed $contentLanguage
     */
    public function setContentLanguage($contentLanguage)
    {
        $this->contentLanguage = $contentLanguage;
    }

    /**
     * @return mixed
     */
    public function getContentLength()
    {
        return $this->contentLength;
    }

    /**
     * @param mixed $contentLength
     */
    public function setContentLength($contentLength)
    {
        $this->contentLength = $contentLength;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }
}