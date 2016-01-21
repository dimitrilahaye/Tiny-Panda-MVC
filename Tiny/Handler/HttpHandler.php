<?php

namespace Tiny\Handler;

use Tiny\Http\HttpConstants;
use Tiny\Http\Response;
use Tiny\Http\TinyRequest;

class HttpHandler {

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

    public static function createRequest(){
        $request = new TinyRequest();
        $request->setRawDatas(http_get_request_body());
        $request->setRedirectStatus($_SERVER['REDIRECT_STATUS']);
        $request->setContentLength($_SERVER['CONTENT_LENGTH']);
        $request->setHttpAccept($_SERVER['HTTP_ACCEPT']);
        $request->setHttpAcceptLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $request->setServerAddr($_SERVER['SERVER_ADDR']);
        $request->setServerPort($_SERVER['SERVER_PORT']);
        $request->setRemoteAddr($_SERVER['REMOTE_ADDR']);
        $request->setRequestScheme($_SERVER['REQUEST_SCHEME']);
        $request->setRedirectQueryString($_SERVER['REDIRECT_QUERY_STRING']);
        $request->setRedirectUrl($_SERVER['REDIRECT_URL']);
        $request->setGatewayInterface($_SERVER['GATEWAY_INTERFACE']);
        $request->setServerProtocol($_SERVER['SERVER_PROTOCOL']);
        $request->setRequestMethod($_SERVER['REQUEST_METHOD']);
        $request->setQueryString($_SERVER['QUERY_STRING']);
        $request->setRequestUri($_SERVER['REQUEST_URI']);
        $request->setRequestArray($_REQUEST);
        return $request;
    }
}