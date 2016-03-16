<?php
namespace Tiny\Router;
use Exception;
use Tiny\Manager\TinyDirectory;
use Tiny\Manager\TinyRoute;
use Tiny\Manager\TinyRequest;

/**
 * Class Router
 * @package Tiny\Router
 *
 * Provides methods to manage the routing system.
 */
class Router {

    /**
     * @var TinyRoute
     *
     * Provides methods to redirect to the controller and the method associated to the URL
     */
    private $tinyRoute;

    public function __construct(){
        $this->tinyRoute = new TinyRoute();
    }

    /**
     * @param $server $_SERVER
     * @param $request TinyRequest
     * @throws Exception
     *
     * Launches routing operations
     */
    public function init($server, TinyRequest $request){
        $route = $this->tinyRoute->getRoute($server);
        $this->launch($route, $request);
    }

    /**
     * @param $route []
     * @param $request TinyRequest
     * @throws Exception
     *
     * Launch routing, as it is written
     */
    private function launch($route, TinyRequest $request){
        if(isset($route[0])) {
            $this->routing($route, $request);
        } else {
            throw new Exception("incorrect URL");
        }
    }

    /**
     * @param $route []
     * @param $request TinyRequest
     * @throws Exception
     *
     * Get and parse routing.ini file to find the controller, method and argument(s)
     */
    private function routing($route, TinyRequest $request){
        $tinyDir = new TinyDirectory();
        $fileIni = $tinyDir->getConfigFile(__DIR__, "routing.ini");
        $args = null;
        if($fileIni != null){
            $routingIni = parse_ini_file($fileIni, true);
            List($args, $route) = $this->tinyRoute->cleanRoute($route, $routingIni);
            $route = $route == "/" ? "." : $route;
            if(isset($routingIni[$route])) {
                $controller = $routingIni[$route]["controller"];
                $controllerClass = $this->tinyRoute->generateController($controller);
                if ($controllerClass == null) {
                    throw new Exception("Class " . $controller . " doesn\'t seem to exist...");
                }
                $action = $routingIni[$route]["method"];
                $this->tinyRoute->generateAndLaunchAction($controllerClass, $action, $args, $request);
            } else {
                throw new Exception("Route doesn't configure");
            }
        } else {
            throw new Exception("Unable to find or read routing.ini...");
        }
    }
}