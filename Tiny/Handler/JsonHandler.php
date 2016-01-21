<?php

namespace Tiny\Handler;

/**
 * Class JsonHandler
 * @package Tiny\Handler
 *
 * Provides methods to serialize and deserialize object and json, objects array and json array
 */
class JsonHandler {

    /**
     * @param $classNamespace
     * @param $object
     * @throws \ErrorException
     * @return string : json object from $classNamespace and an $object
     *
     * Returns a json array from an object and his class's namespace
     */
    public static function serializeObject($classNamespace, $object){
        if(self::isClassExists($classNamespace)) {
            $class = new \ReflectionClass($classNamespace);
            $prop = $class->getProperties();
            $arr = [];
            foreach ($prop as $p) {
                $p->setAccessible(true);
                $key = $p->getName();
                $value = null;
                if(is_object($p->getValue($object))) {
                    $c = new \ReflectionClass($p->getValue($object));
                    $value = json_decode(self::serializeObject($c->getName(), $p->getValue($object)));
                }
                else if(is_array($p->getValue($object))) {
                    $c = new \ReflectionClass($p->getValue($object)[0]);
                    $value = json_decode(self::serializeObjectsArray($c->getName(), $p->getValue($object)));
                }
                else {
                    $value = $p->getValue($object);
                }
                if($value != null){
                    $arr += array($key => $value);
                }
            }
            return json_encode($arr);
        }
        throw new \ErrorException("The class ".$classNamespace." doesn't exist");
    }
    /**
     * @param $classNamespace
     * @param $array
     * @return string : json array from $classNamespace and an $array of objects
     *
     * Returns a json array constructed with the class's namespace and an array of objects
     */
    public static function serializeObjectsArray($classNamespace, $array){
        $jsonArray = [];
        foreach($array as $object) {
            $json = self::serializeObject($classNamespace, $object);
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
    public static function deserializeObject($classNamespace, $json){
        $object = null;
        if(self::isClassExists($classNamespace)) {
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
    public static function deserializeObjectsArray($classNamespace, $jsonArray){
        $array = [];
        foreach(json_decode($jsonArray) as $json) {
            $object = self::deserializeObject($classNamespace, json_encode($json));
            $array[] = $object;
        }
        return $array;
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