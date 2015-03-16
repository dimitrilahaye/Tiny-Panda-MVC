<?php
namespace tiny\Core;
use tiny\Router\Route as Route;

class Core {

    public static function register(){
        spl_autoload_register(array(__CLASS__, 'myAutoloader'));
    }
    public static function init(){
        self::register();
        $url = $_SERVER['REQUEST_URI'];
        new Route($url);
    }
    public static function myAutoloader($class) {
        $nameSpace = explode('\\', $class);
        foreach($nameSpace as $key =>  $value){
            if(end(array_keys($nameSpace)) !== $key){
                $nameSpace[$key] = $value;
            }
        }
        $class = implode('/', $nameSpace).'.php';
        require $class;
    }

}