<?php
namespace Tiny\Tiny;
use Tiny\Router\Router;

class Tiny {

    public static function register(){
        spl_autoload_register(array(__CLASS__, 'myAutoloader'));
    }
    public static function init(){
        self::register();
        $url = $_SERVER['REQUEST_URI'];
        new Router($url);
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