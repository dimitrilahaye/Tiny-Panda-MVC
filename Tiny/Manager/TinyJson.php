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
     * @param $classNamespace
     * @param $object
     * @throws \ErrorException
     * @return string : json object from $classNamespace and an $object
     *
     * Returns a json array from an object and his class's namespace
     */
    public function serializeObject($classNamespace, $object){
        if($this->isClassExists($classNamespace)) {
            $class = new \ReflectionClass($classNamespace);
            $classProperties = $class->getProperties();
            $objects = [];
            foreach ($classProperties as $classProperty) {
                $classProperty->setAccessible(true);
                $propertyName = $classProperty->getName();
                $propertyValue = null;
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
     * @param $classNamespace
     * @param $objects
     * @return string : json array from $classNamespace and an $array of objects
     *
     * Returns a json array constructed with the class's namespace and an array of objects
     */
    public function serializeObjectsArray($classNamespace, $objects){
        $jsonArray = [];
        foreach($objects as $object) {
            $json = $this->serializeObject($classNamespace, $object);
            $jsonArray[] = json_decode($json);
        }
        return json_encode($jsonArray);
    }

    /**
     * @param $classNamespace
     * @param $json
     * @return $object : $object from $classNamespace and a $json
     * @throws \ErrorException
     *
     * Returns an object constructed with the class's namespace and a json object
     */
    public function deserializeObject($classNamespace, $json){
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
     * @param $classNamespace
     * @param $jsonArray
     * @return array : $array of object from $classNamespace and a $jsonArray
     * @throws \ErrorException
     *
     * Returns an array of objects constructed with the class's namespace and a json array
     */
    public function deserializeObjectsArray($classNamespace, $jsonArray){
        $objects = [];
        foreach(json_decode($jsonArray) as $json) {
            $object = $this->deserializeObject($classNamespace, json_encode($json));
            $objects[] = $object;
        }
        return $objects;
    }

    /**
     * @param $classNamespace
     * @return bool
     *
     * Check if the specified class exists
     */
    private function isClassExists($classNamespace){
        if(file_exists(str_replace('\\', '/', $classNamespace.'.php'))){
            return true;
        } return false;
    }
} 