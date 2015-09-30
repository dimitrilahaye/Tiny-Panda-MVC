<?php
namespace Tiny\Tiny;
use Tiny\Router\Router;

class Tiny {

    public static function register(){
        spl_autoload_register(array(__CLASS__, 'myAutoloader'));
    }
    public static function init(){
        self::register();
        Router::init($_SERVER);
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