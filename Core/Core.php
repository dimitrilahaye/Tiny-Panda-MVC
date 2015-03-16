<?php
namespace Core;

class Core {

    public static function getDir(){
        return __DIR__;
    }

    public static function register(){
        spl_autoload_register(array(__CLASS__, 'myAutoloader'));
    }

    public static function myAutoloader($class) {
        $nameSpace = explode('\\', $class);
        foreach($nameSpace as $key =>  $value){
            if(end(array_keys($nameSpace)) !== $key){
                $nameSpace[$key] = $value;
            }
        }

        $class = implode('/', $nameSpace);
        echo 'classe 2 : '.$class.'<br/>';
        require $class . '.php';
    }

}