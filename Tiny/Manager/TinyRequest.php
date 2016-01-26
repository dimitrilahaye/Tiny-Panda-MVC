<?php

namespace Tiny\Manager;

/**
 * Class TinyRequest
 * @package Tiny\Manager
 *
 * Provides the request manage
 */
class TinyRequest {

    private static $instance;

    private function __construct(){}

    public static function getInstance(){
        static::$instance = static::$instance == null ? new TinyRequest() : static::$instance;
        return static::$instance;
    }

    //TODO : a lot of refactoring !!!

    private $_redirectStatus;
    private $_rawDatas;
    private $_contentLength;
    private $_httpAccept;
    private $_httpAcceptLanguage;
    private $_serverAddr;
    private $_serverPort;
    private $_remoteAddr;
    private $_requestScheme;
    private $_redirectQueryString;
    private $_redirectUrl;
    private $_gatewayInterface;
    private $_serverProtocol;
    private $_requestMethod;
    private $_queryString;
    private $_requestUri;
    private $_requestArray;

    public function addOptions(Request_Options $options){
        $array = $options->toArray();
        for ($i = 0; $i < count($array); $i++) { unset($array[$i]); }
        $this->setOptions($array);
    }

    public function addHeaders(Request_Headers $headers){
        $array = $headers->toArray();
        for ($i = 0; $i < count($array); $i++) { unset($array[$i]); }
        $this->setHeaders($array);
    }

    public function addSslOptions(Request_SslOptions $sslOptions){
        $array = $sslOptions->toArray();
        for ($i = 0; $i < count($array); $i++) { unset($array[$i]); }
        $this->setSslOptions($array);
    }

    public function addParams(Request_Params $params){
        $array = $params->toArray();
        $this->setPutData($array["putData"]);
        $this->setRawPostData($array["rawPostData"]);
        $this->setContentType($array["contentType"]);
        $this->setMethod($array["method"]);
        $this->setPutFile($array["putFile"]);
        $this->setUrl($array["url"]);
    }

    /**
     * Launch a GET request
     * @param $url : url to ask for response
     * @return the server response
     */
    public function get($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        $response = curl_exec($curl);
        if (!$response) {
            die("Connection Failure!");
        }
        curl_close($curl);
        return $response;
    }

    /**
     * Launch a POST request
     * @param $url : url to ask for response
     * @param $datas : datas pass as parameters of the request
     * @return the server response
     */
    public function post($url, $datas){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        if($datas != null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $datas);
        }
        $response = curl_exec($curl);
        if (!$response) {
            die("Connection Failure!");
        }
        curl_close($curl);
        return $response;
    }
    /**
     * Launch a DELETE request
     * @param $url : url to ask for response
     * @return the server response
     */
    public function delete($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($curl);
        if (!$response) {
            die("Connection Failure!");
        }
        curl_close($curl);
        return $response;
    }
    /**
     * Launch a PUT request
     * @param $url : url to ask for response
     * @param $datas : datas pass as parameters of the request
     * @return the server response
     */
    public function put($url, $datas){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        if($datas != null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($datas));
        }
        $response = curl_exec($curl);
        if(!$response) {
            die("Connection Failure!");
        }
        curl_close($curl);
        return $response;
    }

    public function render(\HttpMessage $httpMessage) {
        echo $httpMessage->getBody();
    }

    /**
     * @return mixed
     */
    public function getRawDatas() {
        return $this->_rawDatas;
    }

    /**
     * @param mixed $rowDatas
     */
    public function setRawDatas($rawDatas) {
        $this->_rawDatas = $rawDatas;
    }

    /**
     * @return mixed
     */
    public function getRequestArray() {
        return $this->_requestArray;
    }

    /**
     * @param mixed $requestArray
     */
    public function setRequestArray($requestArray) {
        $this->_requestArray = $requestArray;
    }

    /**
     * @return mixed
     */
    public function getContentLength() {
        return $this->_contentLength;
    }

    /**
     * @param mixed $contentLength
     */
    public function setContentLength($contentLength) {
        $this->_contentLength = $contentLength;
    }

    /**
     * @return mixed
     */
    public function getGatewayInterface() {
        return $this->_gatewayInterface;
    }

    /**
     * @param mixed $gatewayInterface
     */
    public function setGatewayInterface($gatewayInterface) {
        $this->_gatewayInterface = $gatewayInterface;
    }

    /**
     * @return mixed
     */
    public function getHttpAccept() {
        return $this->_httpAccept;
    }

    /**
     * @param mixed $httpAccept
     */
    public function setHttpAccept($httpAccept) {
        $this->_httpAccept = $httpAccept;
    }

    /**
     * @return mixed
     */
    public function getHttpAcceptLanguage() {
        return $this->_httpAcceptLanguage;
    }

    /**
     * @param mixed $httpAcceptLanguage
     */
    public function setHttpAcceptLanguage($httpAcceptLanguage) {
        $this->_httpAcceptLanguage = $httpAcceptLanguage;
    }

    /**
     * @return mixed
     */
    public function getQueryString() {
        return $this->_queryString;
    }

    /**
     * @param mixed $queryString
     */
    public function setQueryString($queryString) {
        $this->_queryString = $queryString;
    }

    /**
     * @return mixed
     */
    public function getRedirectQueryString() {
        return $this->_redirectQueryString;
    }

    /**
     * @param mixed $redirectQueryString
     */
    public function setRedirectQueryString($redirectQueryString) {
        $this->_redirectQueryString = $redirectQueryString;
    }

    /**
     * @return mixed
     */
    public function getRedirectStatus() {
        return $this->_redirectStatus;
    }

    /**
     * @param mixed $redirectStatus
     */
    public function setRedirectStatus($redirectStatus) {
        $this->_redirectStatus = $redirectStatus;
    }

    /**
     * @return mixed
     */
    public function getRedirectUrl() {
        return $this->_redirectUrl;
    }

    /**
     * @param mixed $redirectUrl
     */
    public function setRedirectUrl($redirectUrl) {
        $this->_redirectUrl = $redirectUrl;
    }

    /**
     * @return mixed
     */
    public function getRemoteAddr() {
        return $this->_remoteAddr;
    }

    /**
     * @param mixed $remoteAddr
     */
    public function setRemoteAddr($remoteAddr) {
        $this->_remoteAddr = $remoteAddr;
    }

    /**
     * @return mixed
     */
    public function getRequestMethod() {
        return $this->_requestMethod;
    }

    /**
     * @param mixed $requestMethod
     */
    public function setRequestMethod($requestMethod) {
        $this->_requestMethod = $requestMethod;
    }

    /**
     * @return mixed
     */
    public function getRequestScheme() {
        return $this->_requestScheme;
    }

    /**
     * @param mixed $requestScheme
     */
    public function setRequestScheme($requestScheme) {
        $this->_requestScheme = $requestScheme;
    }

    /**
     * @return mixed
     */
    public function getRequestUri() {
        return $this->_requestUri;
    }

    /**
     * @param mixed $requestUri
     */
    public function setRequestUri($requestUri) {
        $this->_requestUri = $requestUri;
    }

    /**
     * @return mixed
     */
    public function getServerAddr() {
        return $this->_serverAddr;
    }

    /**
     * @param mixed $serverAddr
     */
    public function setServerAddr($serverAddr) {
        $this->_serverAddr = $serverAddr;
    }

    /**
     * @return mixed
     */
    public function getServerPort() {
        return $this->_serverPort;
    }

    /**
     * @param mixed $serverPort
     */
    public function setServerPort($serverPort) {
        $this->_serverPort = $serverPort;
    }

    /**
     * @return mixed
     */
    public function getServerProtocol() {
        return $this->_serverProtocol;
    }

    /**
     * @param mixed $serverProtocol
     */
    public function setServerProtocol($serverProtocol) {
        $this->_serverProtocol = $serverProtocol;
    }

} 