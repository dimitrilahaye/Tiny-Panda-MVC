<?php
namespace Tiny\Router;
use Exception;
use Tiny\Handler\DirectoryHandler;
use Tiny\Handler\RouteHandler;
use Tiny\Http\TinyRequest;

/**
 * Class Router
 * @package Tiny\Router
 *
 * Provides methods to manage the routing system.
 */
class Router {

    /**
     * @param $server
     * @param TinyRequest $request
     * @throws Exception
     *
     * Launches routing operations
     */
    public static function init($server, TinyRequest $request){
        $route = RouteHandler::getRoute($server);
        self::launch($route, $request);
    }

    /**
     * @param $route
     * @param $request
     * @throws Exception
     *
     * Launch routing, as it is written
     */
    private function launch($route, TinyRequest $request){
        if(isset($route[0])) {
            self::routing($route, $request);
        } else {
            throw new Exception('incorrect URL');
        }
    }

    /**
     * @param $route
     * @param $request
     * @throws Exception
     *
     * Get and parse routing.init file to find the controller, method and argument(s)
     */
    private function routing($route, TinyRequest $request){
            $fileIni = DirectoryHandler::getConfigFile(__DIR__, 'routing.init');
            $arg = null;
            if($fileIni != null){
                $routing_init = parse_ini_file($fileIni, true);
                List($arg, $route) = RouteHandler::cleanRoute($route, $routing_init);
                $route = $route == "/" ? "." : $route;
                if(isset($routing_init[$route])) {
                    $controller = $routing_init[$route]['controller'];
                    $controllerClass = RouteHandler::generateController($controller);
                    if ($controllerClass == null) {
                        throw new Exception('Class ' . $controller . ' doesn\'t seem to exist...');
                    }
                    $action = $routing_init[$route]['action'];
                    RouteHandler::generateAndLaunchAction($controllerClass, $action, $arg, $request);
                } else {
                    throw new Exception('Route doesn\'t configure');
                }
            } else {
                throw new Exception('Unable to find or read routing.init...');
            }
        }
}