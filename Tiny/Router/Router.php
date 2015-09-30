<?php
namespace Tiny\Router;
use Exception;
use Tiny\Handler\DirectoryHandler;

class Router {

        public static function init($request){
            $route = self::getRoute($request);
            self::launch($route);
        }

    /**
     * @param $request
     * @return route without system directories
     */
    private function getRoute($request){
        $route = DirectoryHandler::getRoute($request);
        return $route;
    }
    private function launch($route){
        if(isset($route[0])) {
            self::routing($route);
        } else {
            throw new Exception('incorrect URL');
        }
    }

    /**
     * @param $route
     * @throws Exception
     * Get and parse routing.init file to find the controller, method and argument(s)
     */
    private function routing($route){
            $fileIni = DirectoryHandler::getConfigFile(__DIR__, 'routing.init');
            $arg = null;
            if($fileIni != null){
                $routing_init = parse_ini_file($fileIni, true);
                if(self::isParam($routing_init, $route)){
                    $arg = self::generateArg($route, $routing_init);
                    $route = self::generateNewRoute($route);
                }
                if(isset($routing_init[$route])) {
                    $controller = $routing_init[$route]['controller'];
                    $controllerClass = self::generateController($controller);
                    if ($controllerClass == null) {
                        throw new Exception('Class ' . $controller . ' doesn\'t seem to exist...');
                    }
                    $method = $routing_init[$route]['method'];
                    self::generateMethod($controllerClass, $method, $arg);
                } else {
                    throw new Exception('Route doesn\'t configure');
                }
            } else {
                throw new Exception('Unable to find or read routing.init...');
            }
        }

    /**
     * @param $fileIni
     * @param $route
     * @return true if route has params
     */
    private function isParam($fileIni, $route){
        if(!isset($fileIni[$route])){
            $route = explode('/', $route);
            array_pop($route);
            $route = implode('/',$route);
            if(isset($fileIni[$route])) {
                return true;
            }
        } return false;
    }

    /**
     * @param $route
     * @param $fileIni
     * @return $arg with route param
     */
    private function generateArg($route, $fileIni){
        $route = explode('/', $route);
        $arg = $route[sizeof($route)-1];
        $route = implode('/', $route);
        $param = ($fileIni[$route]['param']);
        extract(array($param => $arg));
        return $arg;
    }

    /**
     * @param $route
     * @return nice route without param at the end
     */
    private function generateNewRoute($route){
        $route = explode('/', $route);
        array_pop($route);
        return implode('/',$route);
    }

    /**
     * @param $controller
     * @return controller class
     */
    private function generateController($controller) {
            if (class_exists($controller)) {
                return new $controller();
            } else {
                return null;
            }
        }

    /**
     * @param $controller
     * @param $method
     * @param $arg
     * @throws Exception
     * Launch method from the controller $controller
     */
    private function generateMethod($controller, $method, $arg){
        if(method_exists($controller, $method)){
            if($arg != null) {
                $controller->$method($arg);
            } else {
                $controller->$method();
            }
        } else {
            throw new Exception($method.' method doesn\'t seem to exist in class '.$controller.'...');
        }
    }
}