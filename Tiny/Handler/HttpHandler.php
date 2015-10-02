<?php

namespace Tiny\Handler;

use Tiny\Http\HttpConstants;
use Tiny\Http\Request;
use Tiny\Http\Response;
use Tiny\Http\Server;

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
                echo $response->getBody();
            }
        } else {
            throw new \HttpException("No response to send...");
        }
    }

    public static function createRequestWithServer(Server $server){
        $request = new Request();
        $request->setHttpAccept($server->getHttpAccept());
        $request->setHttpAcceptEncoding($server->getHttpAcceptEncoding());
        $request->setHttpAcceptLanguage($server->getHttpAcceptLanguage());
        $request->setHttpCacheControl($server->getHttpCacheControl());
        $request->setHttpConnection($server->getHttpConnection());
        $request->setHttpHost($server->getHttpHost());
        $request->setHttpUserAgent($server->getHttpUserAgent());
        $request->setRedirectStatus($server->getRedirectStatus());
        $request->setRequestMethod($server->getRequestMethod());
        return $request;
    }
}