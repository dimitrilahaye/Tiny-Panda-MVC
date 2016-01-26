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
     * @param $fileIni
     * @param $route
     * @return Bool
     *
     * Returns true if route has args
     */
    public function isArgs($fileIni, $route){
        if($route == "/"){
            return false;
        } else if(!isset($fileIni[$route])){
            $route = explode('/', $route);
            array_pop($route);
            $route = implode('/',$route);
            if(isset($fileIni[$route])) {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $route
     * @return bool
     *
     * Returns true if route has query
     */
    public function isQuery($route){
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
     * Return arg from route params
     */
    public function generateArg($route, $fileIni){
        $route = explode('/', $route);
        $arg = $route[sizeof($route)-1];
        unset($route[sizeof($route)-1]);
        $route = implode('/', $route);
        $param = $fileIni[$route]['argument'];
        extract(array($param => $arg));
        return $arg;
    }

    /**
     * @param $route
     * @return String
     *
     * Returns nice route without argument (eg. my/route/12)
     */
    public function generateRouteArgsLess($route){
        $route = explode('/', $route);
        array_pop($route);
        return implode('/',$route);
    }

    /**
     * @param $route
     * @return array
     *
     * Returns nice route without query at the end (eg. my/route?query=12&anotherquery=24)
     */
    public function generateRouteQueryLess($route) {
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
     * @param $arg
     * @param $request
     * @throws \Exception
     *
     * Generate a method with route string, then launch this method
     */
    public function generateAndLaunchAction($controller, $action, $arg, $request){
        if(method_exists($controller, $action)){
            if($arg != null) {
                $controller->$action($request, $arg);
            } else {
                $controller->$action($request);
            }
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
        $arg = null;
        if (self::isArgs($routing_init, $route)) {
            $arg = $this->generateArg($route, $routing_init);
            $route = $this->generateRouteArgsLess($route);
            return array($arg, $route);
        } else if ($this->isQuery($route)) {
            $route = $this->generateRouteQueryLess($route);
            return array($arg, $route);
        }return array($arg, $route);
    }
} 