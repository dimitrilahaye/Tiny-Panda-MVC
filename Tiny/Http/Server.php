<?php

namespace Tiny\Http;


/**
 * Class Server
 * @package Tiny\Http
 */
class Server {
    private $redirectStatus;
    private $httpHost;
    private $httpUserAgent;
    private $httpAccept;
    private $httpAcceptLanguage;
    private $httpAcceptEncoding;
    private $httpConnection;
    private $httpCacheControl;
    private $path;
    private $serverSignature;
    private $serverSoftware;
    private $serverName;
    private $serverADDR;
    private $serverPort;
    private $remoteADDR;
    private $documentRoot;
    private $requestScheme;
    private $contextPrefix;
    private $contextDocumentRoot;
    private $serverAdmin;
    private $scriptFileName;
    private $remotePort;
    private $redirectURL;
    private $gatewayInterface;
    private $serverProtocol;
    private $requestMethod;
    private $queryString;
    private $requestURI;
    private $scriptName;
    private $PHPSelf;
    private $requestTimeFloat;
    private $requestTime;

    function __construct($request){
        $this->PHPSelf = $request['PHP_SELF'];
        $this->contextDocumentRoot = $request['CONTEXT_DOCUMENT_ROOT'];
        $this->contextPrefix = $request['CONTEXT_PREFIX'];
        $this->documentRoot = $request['DOCUMENT_ROOT'];
        $this->gatewayInterface = $request['GATEWAY_INTERFACE'];
        $this->httpAccept = $request['HTTP_ACCEPT'];
        $this->httpAcceptEncoding = $request['HTTP_ACCEPT_ENCODING'];
        $this->httpAcceptLanguage = $request['HTTP_ACCEPT_LANGUAGE'];
        $this->httpCacheControl = $request['HTTP_CACHE_CONTROL'];
        $this->httpConnection = $request['HTTP_CONNECTION'];
        $this->httpHost = $request['HTTP_HOST'];
        $this->httpUserAgent = $request['HTTP_USER_AGENT'];
        $this->path = $request['PATH'];
        $this->queryString = $request['QUERY_STRING'];
        $this->redirectStatus = $request['REDIRECT_STATUS'];
        $this->redirectURL = $request['REDIRECT_URL'];
        $this->remoteADDR = $request['REMOTE_ADDR'];
        $this->remotePort = $request['REMOTE_PORT'];
        $this->requestMethod = $request['REQUEST_METHOD'];
        $this->requestScheme = $request['REQUEST_SCHEME'];
        $this->requestTime = $request['REQUEST_TIME'];
        $this->requestTimeFloat = $request['REQUEST_TIME_FLOAT'];
        $this->requestURI = $request['REQUEST_URI'];
        $this->scriptFileName = $request['SCRIPT_FILE_NAME'];
        $this->scriptName = $request['SCRIPT_NAME'];
        $this->serverADDR = $request['SERVER_ADDR'];
        $this->serverAdmin = $request['SERVER_ADMIN'];
        $this->serverName = $request['SERVER_NAME'];
        $this->serverPort = $request['SERVER_PORT'];
        $this->serverProtocol = $request['SERVER_PROTOCOL'];
        $this->serverSignature = $request['SERVER_SIGNATURE'];
        $this->serverSoftware = $request['SERVER_SOFTWARE'];
    }

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
    public function getPHPSelf(){
        return $this->PHPSelf;
    }

    /**
     * @param mixed $PHPSelf
     */
    public function setPHPSelf($PHPSelf){
        $this->PHPSelf = $PHPSelf;
    }

    /**
     * @return mixed
     */
    public function getContextDocumentRoot(){
        return $this->contextDocumentRoot;
    }

    /**
     * @param mixed $contextDocumentRoot
     */
    public function setContextDocumentRoot($contextDocumentRoot){
        $this->contextDocumentRoot = $contextDocumentRoot;
    }

    /**
     * @return mixed
     */
    public function getContextPrefix(){
        return $this->contextPrefix;
    }

    /**
     * @param mixed $contextPrefix
     */
    public function setContextPrefix($contextPrefix){
        $this->contextPrefix = $contextPrefix;
    }

    /**
     * @return mixed
     */
    public function getDocumentRoot(){
        return $this->documentRoot;
    }

    /**
     * @param mixed $documentRoot
     */
    public function setDocumentRoot($documentRoot){
        $this->documentRoot = $documentRoot;
    }

    /**
     * @return mixed
     */
    public function getGatewayInterface(){
        return $this->gatewayInterface;
    }

    /**
     * @param mixed $gatewayInterface
     */
    public function setGatewayInterface($gatewayInterface){
        $this->gatewayInterface = $gatewayInterface;
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
    public function getPath(){
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path){
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getQueryString(){
        return $this->queryString;
    }

    /**
     * @param mixed $queryString
     */
    public function setQueryString($queryString){
        $this->queryString = $queryString;
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
    public function getRedirectURL(){
        return $this->redirectURL;
    }

    /**
     * @param mixed $redirectURL
     */
    public function setRedirectURL($redirectURL){
        $this->redirectURL = $redirectURL;
    }

    /**
     * @return mixed
     */
    public function getRemoteADDR(){
        return $this->remoteADDR;
    }

    /**
     * @param mixed $remoteADDR
     */
    public function setRemoteADDR($remoteADDR){
        $this->remoteADDR = $remoteADDR;
    }

    /**
     * @return mixed
     */
    public function getRemotePort(){
        return $this->remotePort;
    }

    /**
     * @param mixed $remotePort
     */
    public function setRemotePort($remotePort){
        $this->remotePort = $remotePort;
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

    /**
     * @return mixed
     */
    public function getRequestScheme(){
        return $this->requestScheme;
    }

    /**
     * @param mixed $requestScheme
     */
    public function setRequestScheme($requestScheme){
        $this->requestScheme = $requestScheme;
    }

    /**
     * @return mixed
     */
    public function getRequestTime(){
        return $this->requestTime;
    }

    /**
     * @param mixed $requestTime
     */
    public function setRequestTime($requestTime){
        $this->requestTime = $requestTime;
    }

    /**
     * @return mixed
     */
    public function getRequestTimeFloat(){
        return $this->requestTimeFloat;
    }

    /**
     * @param mixed $requestTimeFloat
     */
    public function setRequestTimeFloat($requestTimeFloat){
        $this->requestTimeFloat = $requestTimeFloat;
    }

    /**
     * @return mixed
     */
    public function getRequestURI(){
        return $this->requestURI;
    }

    /**
     * @param mixed $requestURI
     */
    public function setRequestURI($requestURI){
        $this->requestURI = $requestURI;
    }

    /**
     * @return mixed
     */
    public function getScriptFileName(){
        return $this->scriptFileName;
    }

    /**
     * @param mixed $scriptFileName
     */
    public function setScriptFileName($scriptFileName){
        $this->scriptFileName = $scriptFileName;
    }

    /**
     * @return mixed
     */
    public function getScriptName(){
        return $this->scriptName;
    }

    /**
     * @param mixed $scriptName
     */
    public function setScriptName($scriptName){
        $this->scriptName = $scriptName;
    }

    /**
     * @return mixed
     */
    public function getServerADDR(){
        return $this->serverADDR;
    }

    /**
     * @param mixed $serverADDR
     */
    public function setServerADDR($serverADDR){
        $this->serverADDR = $serverADDR;
    }

    /**
     * @return mixed
     */
    public function getServerAdmin(){
        return $this->serverAdmin;
    }

    /**
     * @param mixed $serverAdmin
     */
    public function setServerAdmin($serverAdmin){
        $this->serverAdmin = $serverAdmin;
    }

    /**
     * @return mixed
     */
    public function getServerName(){
        return $this->serverName;
    }

    /**
     * @param mixed $serverName
     */
    public function setServerName($serverName){
        $this->serverName = $serverName;
    }

    /**
     * @return mixed
     */
    public function getServerPort(){
        return $this->serverPort;
    }

    /**
     * @param mixed $serverPort
     */
    public function setServerPort($serverPort){
        $this->serverPort = $serverPort;
    }

    /**
     * @return mixed
     */
    public function getServerProtocol(){
        return $this->serverProtocol;
    }

    /**
     * @param mixed $serverProtocol
     */
    public function setServerProtocol($serverProtocol){
        $this->serverProtocol = $serverProtocol;
    }

    /**
     * @return mixed
     */
    public function getServerSignature(){
        return $this->serverSignature;
    }

    /**
     * @param mixed $serverSignature
     */
    public function setServerSignature($serverSignature){
        $this->serverSignature = $serverSignature;
    }

    /**
     * @return mixed
     */
    public function getServerSoftware(){
        return $this->serverSoftware;
    }

    /**
     * @param mixed $serverSoftware
     */
    public function setServerSoftware($serverSoftware){
        $this->serverSoftware = $serverSoftware;
    }

} 