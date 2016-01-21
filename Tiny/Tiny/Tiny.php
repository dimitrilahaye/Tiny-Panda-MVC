<?php
namespace Tiny\Tiny;

use Tiny\Router\Router;
use Tiny\Handler\HttpHandler;
use Tiny\Handler\CacheHandler;

class Tiny {

    public static function init(){
        //autoloader
        self::register();
        //TODO : code this method again
        $request = HttpHandler::createRequest();
        //init the cache files
        CacheHandler::initCacheFiles();
        //launch the controller and the associated method
        Router::init($_SERVER, $request);
    }

    private function register(){
        spl_autoload_register(array(__CLASS__, 'tinyAutoLoader'));
    }

    public static function tinyAutoLoader($class) {
        $nameSpace = explode('\\', $class);
        foreach($nameSpace as $key =>  $value){
            //prevents error "Strict Standards: Only variables should be passed"
            $nameSpaceKeys = array_keys($nameSpace);
            if(end($nameSpaceKeys) !== $key){
                $nameSpace[$key] = $value;
            }
        }
        $class = implode('/', $nameSpace).'.php';
        require $class;
    }
}