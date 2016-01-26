<?php

namespace Tiny\Manager;

use Tiny\Http\HttpConstants;
use Tiny\Http\Response;

/**
 * Class TinyHttp
 * @package Tiny\Manager
 */
class TinyHttp {

    /**
     * @var TinyManager
     *
     * Provides the services for Project controllers :
     *      json serializer, request manager, response manager, etc...
     * There, we just want to get the request service
     */
    private $manager;

    public function __construct(){
        $this->manager = new TinyManager();
    }

    public static function sendResponse(Response $response){
        if($response != null) {
            if ($response->getContentLength() != null){
                header('Content-length: ' . $response->getContentLength());
            }
            if ($response->getContentLanguage() != null){
                header('Content-Language: ' . $response->getContentLanguage());
            }
            if ($response->getContentEncoding() != null){
                header('Content-Encoding: ' . $response->getContentEncoding());
            }
            if ($response->getDate() != null){
                header('Date: ' . $response->getDate());
            }
            if ($response->getExpires() != null){
                header('Expires: ' . $response->getExpires());
            }
            if ($response->getLocation() != null){
                header('Location: ' . $response->getLocation());
            }
            if ($response->getServer() != null){
                header('Server: ' . $response->getServer());
            }
            if ($response->getContentType() != null){
                header('Content-Type: ' . $response->getContentType());
            }
            if ($response->getStatus() == null){
                $response->setStatus(HttpConstants::_200_OK);
            }
            header(HttpConstants::getStatusMessage($response->getStatus()), true , $response->getStatus());
            if ($response->getTransfertEncoding() != null){
                header('Transfert-Encoding: ' . $response->getTransfertEncoding());
            }
            if ($response->getBody() != null) {
                //echo $response->getBody();
            }
        } else {
            throw new \HttpException("No response to send...");
        }
    }

    public function createRequest(){
        $request = $this->manager->get("request");
        $request->setRawDatas(http_get_request_body());
        if(isset($_SERVER['REDIRECT_STATUS'])) {
            $request->setRedirectStatus($_SERVER['REDIRECT_STATUS']);
        }
        if(isset($_SERVER['CONTENT_LENGTH'])) {
            $request->setContentLength($_SERVER['CONTENT_LENGTH']);
        }
        if(isset($_SERVER['HTTP_ACCEPT'])) {
            $request->setHttpAccept($_SERVER['HTTP_ACCEPT']);
        }
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $request->setHttpAcceptLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        }
        if(isset($_SERVER['SERVER_ADDR'])) {
            $request->setServerAddr($_SERVER['SERVER_ADDR']);
        }
        if(isset($_SERVER['SERVER_PORT'])) {
            $request->setServerPort($_SERVER['SERVER_PORT']);
        }
        if(isset($_SERVER['REMOTE_ADDR'])) {
            $request->setRemoteAddr($_SERVER['REMOTE_ADDR']);
        }
        if(isset($_SERVER['REQUEST_SCHEME'])) {
            $request->setRequestScheme($_SERVER['REQUEST_SCHEME']);
        }
        if(isset($_SERVER['REDIRECT_QUERY_STRING'])) {
            $request->setRedirectQueryString($_SERVER['REDIRECT_QUERY_STRING']);
        }
        if(isset($_SERVER['REDIRECT_URL'])) {
            $request->setRedirectUrl($_SERVER['REDIRECT_URL']);
        }
        if(isset($_SERVER['GATEWAY_INTERFACE'])) {
            $request->setGatewayInterface($_SERVER['GATEWAY_INTERFACE']);
        }
        if(isset($_SERVER['SERVER_PROTOCOL'])) {
            $request->setServerProtocol($_SERVER['SERVER_PROTOCOL']);
        }
        if(isset($_SERVER['REQUEST_METHOD'])) {
            $request->setRequestMethod($_SERVER['REQUEST_METHOD']);
        }
        if(isset($_SERVER['QUERY_STRING'])) {
            $request->setQueryString($_SERVER['QUERY_STRING']);
        }
        if(isset($_SERVER['REQUEST_URI'])) {
            $request->setRequestUri($_SERVER['REQUEST_URI']);
        }
        $request->setRequestArray($_REQUEST);
        return $request;
    }
}