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
     * TODO : methode deserializeObject($classNamespace, $json)
     * Pour chaque json.key on fait un set sur le nouvel objet ! (un peu de norme bordel !!)
     */
} 