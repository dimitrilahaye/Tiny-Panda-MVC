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

    public function findMatchingRoute($route, $fileIni){
        $route = explode('/', $route);
        $size = sizeof($route);
        $args = [];
        $matchingRoutes = [];
        $matchingRoute = "";
        $_matchingRoutesReturn = false;
        $_matchingRouteReturn = false;
        $fileIniKeys = array_keys($fileIni);
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
     * @param $fileIni
     * @param $route
     * @return Bool
     *
     * Returns true if route has args
     */
    public function isArgs($fileIni, $route){
        $route = $this->findMatchingRoute($route, $fileIni);
        echo "isArgs : ".$route;
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
        // ici on considère que l'arg est à la fin de la route
        // on considère qu'il n'y a qu'un seul argument du coup
        $arg = $route[sizeof($route)-1];
        // mais il peut y en avoir plusieurs :
        // http://monsite.com/user/12/job/23
        // in router.ini
        // [user/::/job/::]
        // argument[] = id1
        // argument[] = id2
        /*
            if()        
            $args =  $fileIni[$route]['argument'];
        */
        unset($route[sizeof($route)-1]);
        $route = implode('/', $route);
        $param = $fileIni[$route]['argument'];
        extract(array($param => $arg));
        return $arg;
    }

    /**
     * @param $route
     * @param $fileIni
     * @return String
     *
     * Returns nice route (eg. my/route/12 becomes my/route/$arg)
     */
    public function generateNiceRoute($route, $fileIni){
        $matchingRoute = $this->findMatchingRoute($route, $fileIni);
        $matchingRouteAsArray = explode("/", $matchingRoute);
        $route = explode('/', $route);
        $idx_args = 0;
        $returnedRoute = "";
        $args = $fileIni[$matchingRoute]['argument'];

        for ($i=0; $i < sizeof($matchingRouteAsArray); $i++) {
            if($i%2 == 1){
                $returnedRoute .= "$".$args[$idx_args]."/";
                $idx_args++;
            } else if($i%2 == 0){
                $returnedRoute .= $matchingRouteAsArray[$i]."/";
            }
        }
        $returnedRoute = explode("/", $returnedRoute);
        array_pop($returnedRoute);
        $returnedRoute = implode("/", $returnedRoute);
        echo $returnedRoute;
        return $returnedRoute;
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
            echo "<br/>this<br/>";
            // retourner les arguments de la route !!!
            // $arg = $this->generateArg($route, $routing_init);
            $route = $this->generateNiceRoute($route, $routing_init);
            return array($arg, $route);
        } else if ($this->isQuery($route)) {
            echo "<br/>query<br/>";
            $route = $this->generateRouteQueryLess($route);
            return array($arg, $route);
        }
        echo "<br/>nothing<br/>";
        return array($arg, $route);
    }
} 