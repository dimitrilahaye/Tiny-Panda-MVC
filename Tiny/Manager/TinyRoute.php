<?php

namespace Tiny\Manager;


/**
 * Class TinyRoute
 * @package Tiny\Manager
 *
 * Provides methods to manage router work
 */
class TinyRoute {

    /**
     * @param $request
     * @return string
     *
     * Return route without system directories
     */
    public function getRoute($request){
        $url = $request['REQUEST_URI'];
        $dir = $request['SCRIPT_NAME'];
        $url = rtrim(ltrim($url, '/'), '/');
        $dir = rtrim(ltrim($dir, '/'), '/');
        $dir = explode('/', $dir);
        array_pop($dir);
        $url = str_replace($dir, '', $url);
        $url = ltrim($url, '/');
        return $url == "" ? "/" : $url;
    }

    /**
     * @param $route
     * @param $fileIni
     * @return String
     *
     * Returns route name if arguments inside (eg. http://mysite.com/route/12 becomes /route/$arg)
     */
    public function generateRouteName($route, $fileIni){
        $route = explode('/', $route);
        $fileIniKeys = array_keys($fileIni);
        $matchingRoutes = [];
        $matchingRoutes = $this->getMatchingRoutes($fileIniKeys, $route);
        return $this->getMatchingRoute($matchingRoutes, $route);
    }

    /**
     * @param $fileIniKeys
     * @param $route
     * @return String
     *
     * Returns all routes thats match with $route passed in argument
     */
    private function getMatchingRoutes($fileIniKeys, $route){
        $size = sizeof($route);
        $matchingRoutes = [];
        $_matchingRoutesReturn = false;
        foreach($fileIniKeys as $key) { 
            $keyAsArray = explode('/', $key);
            if(sizeof($keyAsArray) == $size){
                for ($i=0; $i < (sizeof($keyAsArray)-1) ; $i++) {
                    if($i%2 == 0){
                        if($keyAsArray[$i] == $route[$i]){
                            $_matchingRoutesReturn = true;
                        }
                    }
                }
                if($_matchingRoutesReturn){
                    $matchingRoutes[] = $key;
                }
            }
        }
        return $matchingRoutes;
    }

    /**
     * @param $matchingRoutes
     * @param $route
     * @return String
     *
     * Returns route name that matches with the $route passed in argument
     */
    private function getMatchingRoute($matchingRoutes, $route){
        $matchingRoute = "";
        $_matchingRouteReturn = false;
        foreach ($matchingRoutes as $key) {
            $matchingRouteAsArray = explode("/", $key);
            for ($i=0; $i < (sizeof($matchingRouteAsArray)-1); $i++) { 
                if(!$i&1){
                    if($matchingRouteAsArray[$i] == $route[$i]){
                        $_matchingRouteReturn = true;
                    } else {
                        $_matchingRouteReturn = false;
                    }
                }
            }
            if($_matchingRouteReturn){
                $matchingRoute = $key;
            }
        }
        return $matchingRoute;
    }

    /**
     * @param $routeURL
     * @param $args
     * @return String
     *
     * Returns nice route with arguments $args (eg. my/route/$arg becomes my/route/12)
     */
    public function generateRouteWithArguments($routeURL, $args){
        $innerArgs = [];
        foreach ($args as $key => $value) {
            $innerArgs[] = $value;
        }
        $finalRoute = "";
        $routeURLAsArray = explode("/", $routeURL);
        $idx = 0;
        for ($i=0; $i < sizeof($routeURLAsArray); $i++) { 
            if($i % 2 == 0){
                $finalRoute .= $routeURLAsArray[$i]."/";
            } else {
                $finalRoute .= $innerArgs[$idx]."/";
                $idx++;
            }
        }
        $finalRoute = substr($finalRoute, 0, -1);
        return $finalRoute;
    }

    /**
     * @param $fileIni
     * @param $route
     * @return Bool
     *
     * Returns true if route has args
     */
    private function isArgs($fileIni, $route){
        $route = $this->generateRouteName($route, $fileIni);
        if($route == "/"){
            return false;
        } else if(!isset($fileIni[$route])){
            return false;
        } else if(isset($fileIni[$route])) {
            if(isset($fileIni[$route]["argument"])){
                return true;
            }
        }
    }

    /**
     * @param $route
     * @return bool
     *
     * Returns true if route has query
     */
    private function isQuery($route){
        if($route == "/"){
            return false;
        } else if(strpos($route, "?")){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $route
     * @param $fileIni
     * @return $arg
     *
     * Return arg(s) from route params
     */
    private function generateArg($route, $fileIni){
        $cleanedRoute = $this->generateRouteName($route, $fileIni);
        $routeAsArray = explode("/", $route);
        $finalArgs = [];
        if(isset($fileIni[$cleanedRoute]["argument"])){
            $arguments = $fileIni[$cleanedRoute]["argument"];
            $idx = 0;
            if(sizeof($arguments) > 0){
                for ($i=0; $i < sizeof($arguments); $i++) {
                    $idx++;
                    $finalArgs[$arguments[$i]] = $routeAsArray[$i + $idx];
                }
            }
        } else {
            throw new Exception("Route doesn't have arguments...");
        }
        return $finalArgs;
    }

    /**
     * @param $route
     * @return array
     *
     * Returns nice route without query at the end (eg. my/route?query=12&anotherquery=24)
     */
    private function generateRouteQueryLess($route) {
        $route = explode("?", $route);
        $route = $route[0];
        return $route;
    }

    /**
     * @param $controller
     * @return $controller
     *
     * Generate a controller and instantiate it with route string
     */
    public function generateController($controller) {
        if (class_exists($controller)) {
            return new $controller();
        } else {
            return null;
        }
    }

    /**
     * @param $controller
     * @param $action
     * @param $args
     * @param $request
     * @throws \Exception
     *
     * Generate a method with route string, then launch this method
     */
    public function generateAndLaunchAction($controller, $action, $args, $request){
        if(method_exists($controller, $action)){
            if($args != null) {
                $request->setArguments($args);
            }
            $controller->$action($request);
        } else {
            throw new \Exception($action.' method doesn\'t seem to exist in class '.$controller.'...');
        }
    }

    /**
     * @param $route
     * @param $routing_init
     * @return array
     *
     * Returns args and route without argument or query
     */
    public function cleanRoute($route, $routing_init) {
        $args = null;
        if (self::isArgs($routing_init, $route)) {
            $args = $this->generateArg($route, $routing_init);
            $route = $this->generateRouteName($route, $routing_init);
            return array($args, $route);
        } else if ($this->isQuery($route)) {
            $route = $this->generateRouteQueryLess($route);
            return array($args, $route);
        }
        return array($args, $route);
    }
} 