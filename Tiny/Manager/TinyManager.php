<?php

namespace Tiny\Manager;

/**
 * Class TinyManager
 * @package Tiny\Manager
 *
 * General class in charge of provide the utils class like TinyJson, TinyRequest or TinyResponse
 */
class TinyManager {

    /**
     * @var array[]
     *
     * The array for services json, request, response, etc...
     */
    private $services;

    public function get($service){
        if(!isset($this->services)){
            $this->initServicesArray();
        }
        if(isset($this->services[$service])){
            return $this->services[$service];
        }
    }

    /**
     *
     * Provides the array of services json, request, response, etc...
     */
    private function initServicesArray(){
        $this->services = array(
            "json" => TinyJson::getInstance(),
            "request" => TinyRequest::getInstance(),
            "pdo" => new TinyPDO()
        );
    }

} 