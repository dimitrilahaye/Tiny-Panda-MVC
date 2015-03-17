<?php
namespace Tiny\Core;
use Tiny\Router\Route;

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
//        var_dump($nameSpace);echo '<br/>';
        $class = implode('/', $nameSpace).'.php';
        require $class;
    }

}