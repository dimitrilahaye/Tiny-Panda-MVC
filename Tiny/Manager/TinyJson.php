<?php

namespace Tiny\Manager;

/**
 * Class TinyJson
 * @package Tiny\Manager
 *
 * Provides methods to serialize and deserialize object and json, objects array and json array
 */
class TinyJson {

    private static $instance;

    private function __construct(){}

    public static function getInstance(){
        static::$instance = static::$instance == null ? new TinyJson() : static::$instance;
        return static::$instance;
    }
    
    /**
     * @param type String $classNamespace : the class name with namespace
     * @param type Json $json : the json to transform in object
     * @return type Object : the object we want to return
     * 
     * Returns an object from a json and the class's namespace
     * of the object we want to return
     */
    public function jsonToObject($classNamespace, $json){
        if(is_array(json_decode($json))){
            return $this->deserializeJsonArray($classNamespace, $json);
        }
        return $this->deserializeJson($classNamespace, $json);
    }
    
    /**
     * @param type String $classNamespace : the class name with namespace
     * @param type Object $object : the object to transform into json
     * @return type Json : a json object
     * 
     * Returns a json from an object and his class's namespace
     */
    public function objectToJson($classNamespace, $object){
        if(is_array($object)){
            return $this->serializeObjectsArray($classNamespace, $object);
        }
        return $this->serializeObject($classNamespace, $object);
    }

    /**
     * @param String $classNamespace : the class name with namespace
     * @param $object : the object we want to transform into json
     * @throws \ErrorException
     * @return string : json object from $classNamespace and an $object
     *
     * Returns a json array from an object and his class's namespace
     */
    private function serializeObject($classNamespace, $object){
        if($this->isClassExists($classNamespace)) {
            $class = new \ReflectionClass($classNamespace);
            $classProperties = $class->getProperties();
            $objects = [];
            foreach ($classProperties as $classProperty) {
                $classProperty->setAccessible(true);
                $propertyName = $classProperty->getName();
                $propertyValue = null;
                //englober le if dans une méthode
                if(is_object($classProperty->getValue($object))) {
                    $subClass = new \ReflectionClass($classProperty->getValue($object));
                    $propertyValue = json_decode($this->serializeObject($subClass->getName(), $classProperty->getValue($object)));
                }
                else if(is_array($classProperty->getValue($object))) {
                    $subClass = new \ReflectionClass($classProperty->getValue($object)[0]);
                    $propertyValue = json_decode($this->serializeObjectsArray($subClass->getName(), $classProperty->getValue($object)));
                }
                else {
                    $propertyValue = $classProperty->getValue($object);
                }
                if($propertyValue != null){
                    $objects += array($propertyName => $propertyValue);
                }
            }
            return json_encode($objects);
        }
        throw new \ErrorException("The class ".$classNamespace." doesn't exist");
    }
    /**
     * @param String $classNamespace : the class name with namespace
     * @param [] $objects : the array of objects we want to transform into json array
     * @return String : json array from $classNamespace and an $array of objects
     *
     * Returns a json array constructed with the class's namespace and an array of objects
     */
    private function serializeObjectsArray($classNamespace, $objects){
        $jsonArray = [];
        foreach($objects as $object) {
            $json = $this->serializeObject($classNamespace, $object);
            $jsonArray[] = json_decode($json);
        }
        return json_encode($jsonArray);
    }

    /**
     * @param type String $classNamespace : the class name with namespace
     * @param type Json $json : the json to transform in object
     * @return $object : $object from $classNamespace and a $json
     * @throws \ErrorException
     *
     * Returns an object constructed with the class's namespace and a json object
     */
    private function deserializeJson($classNamespace, $json){
        $object = null;
        if($this->isClassExists($classNamespace)) {
            $object = new $classNamespace();
            $json = json_decode($json);
            foreach($json as $key => $value){
                $method = 'set'.ucfirst($key);
                if(method_exists($object, $method)) {
                    $object->$method($value);
                } else {
                    throw new \ErrorException("Method ".$method." doesn't exist !");
                }
            }
        } else {
            throw new \ErrorException("The class ".$classNamespace." doesn't exist");
        }
        return $object;
    }

    /**
     * @param type String $classNamespace : the class name with namespace
     * @param type JsonArray $jsonArray : the json array to transform in objects array
     * @return array [] : $array of object from $classNamespace and a $jsonArray
     * @throws \ErrorException
     *
     * Returns an array of objects constructed with the class's namespace and a json array
     */
    private function deserializeJsonArray($classNamespace, $jsonArray){
        $objects = [];
        foreach(json_decode($jsonArray) as $json) {
            $object = $this->deserializeJson($classNamespace, json_encode($json));
            $objects[] = $object;
        }
        return $objects;
    }

    /**
     * @param String $classNamespace : class name we want to evaluate
     * @return bool : true if class exists, false if not
     *
     * Check if the specified class exists
     */
    private function isClassExists($classNamespace){
        if(file_exists(str_replace('\\', '/', $classNamespace.'.php'))){
            return true;
        } return false;
    }
} 