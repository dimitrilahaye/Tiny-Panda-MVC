<?php
namespace Tiny\Tiny;

use Tiny\Manager\TinyCache;
use Tiny\Manager\TinyHttp;
use Tiny\Router\Router;

/**
 * Class Tiny
 * @package Tiny\Tiny
 *
 * This class will initialize the php app.
 */
class Tiny {

    /**
     *
     * Launches the autoloader, generates the cache files then launches the router
     */
    public function init(){
        //autoloader
        $this->register();
        //create request
        $tinyHttp = new TinyHttp();
        $request = $tinyHttp->createRequest();
        //init the cache files
        $tinyCache = new TinyCache();
        $tinyCache->initCacheFiles();
        //launch the controller and the associated method
        $tinyRouter = new Router();
        $tinyRouter->init($_SERVER, $request);
    }

    /**
     *
     * Launches the autoloader
     */
    private static function register(){
        spl_autoload_register(array(__CLASS__, 'tinyAutoLoader'));
    }

    /**
     * @param $class : class.php to register.
     *
     * Autoloader of Tiny Panda Framework
     */
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