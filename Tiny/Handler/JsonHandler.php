<?php

namespace Tiny\Handler;


class JsonHandler {

    /**
     * @param $classNamespace
     * @param $object
     * @throws \ErrorException
     * @return string : json object from $classNamespace and an $object
     */
    public static function serializeObject($classNamespace, $object){
        if(file_exists(str_replace('\\', '/', $classNamespace.'.php'))) {
            $class = new \ReflectionClass($classNamespace);
            $prop = $class->getProperties();
            $arr = [];
            foreach ($prop as $p) {
                $p->setAccessible(true);
                $arr += array($p->getName() => $p->getValue($object));
            }
            return json_encode($arr);
        }
        throw new \ErrorException("The class ".$classNamespace." doesn't exist");
    }

    /**
     * @param $classNamespace
     * @param $array
     * @return string : json array from $classNamespace and an $array of objects
     */
    public static function serializeObjectsArray($classNamespace, $array){
        $jsonArray = [];
        foreach($array as $object) {
            $json = self::serializeObject($classNamespace, $object);
            $jsonArray[] = json_decode($json);
        }
        return json_encode($jsonArray);
    }
} 