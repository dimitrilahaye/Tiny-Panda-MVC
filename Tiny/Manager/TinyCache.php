<?php

namespace Tiny\Manager;

use \Exception;

/**
 * Class TinyCache
 * @package Tiny\Manager
 *
 * Provides methods to create cache files.
 */
class TinyCache {

    /**
     * @throws Exception
     *
     * Generates all the cache files
     */
    public function initCacheFiles(){
        $this->createRouteCacheFile();
    }
    
    /**
     * @throws Exception
     * 
     * If a routeCache.ini exists, the method destroys it then regenerates it.
     * It will delete routeCache.ini, then recreate it.
     */
    public function regenerateRouteCacheFile(){
        $tinyDir = new TinyDirectory();
        $routeCacheFile = $tinyDir->getRouteCacheIni();
        if(file_exists($routeCacheFile)) {
            chmod($routeCacheFile, 0777);
            unlink($routeCacheFile);
            $this->createRouteCacheFile();
        } else {
            throw new Exception('Unable to find or read routeCache.ini...');
        }
    }

    /**
     * @throws Exception
     *
     * Generates the cache file for the route
     */
    private function createRouteCacheFile(){
        $tinyDir = new TinyDirectory();
        $cacheDir = $tinyDir->getCacheDir(__DIR__);
        if(!file_exists($cacheDir)) {
            mkdir($cacheDir);
        }
        $routeCacheFilePath = $cacheDir . DIRECTORY_SEPARATOR . "routeCache.ini";
        $this->createCacheFile($routeCacheFilePath);
        $fileIni = $tinyDir->getConfigFile(__DIR__, 'routing.ini');
        if ($fileIni != null) {
            $routingIni = parse_ini_file($fileIni, true);
            $text = $this->generateRouteCacheContent($routingIni);
            $this->writeInCacheFile($routeCacheFilePath, $text);

        } else {
            throw new Exception('Unable to find or read routing.ini...');
        }
    }
    
    /**
     * @param type String $routingIni : path to the routing.ini file
     * 
     * Will generate the content for the routeCache.ini file
     */
    private function generateRouteCacheContent($routingIni){
        $text = "";
        foreach ($routingIni as $key => $value) {
            $lib = $key;
            List($controller, $name, $action, $arguments) = $this->manageRoutingSections($value);
            $text .= "\n[" . $name . "]\n";
            $text .= "controller = " . $controller . "\n";
            $text .= "action = " . $action . "\n";
            $text .= "route = " . $lib . "\n";
            if (sizeof($arguments) > 0) {
                foreach ($arguments as $arg) {
                    $text .= "argument[] = " . $arg . "\n";
                }
            }
        }
        return $text;
    }
    
    /**
     * @param type [] $routingSection : one section in the routeCache.ini
     * @return type String $text : the content of one section for the routeCache.ini
     */
    private function manageRoutingSections($routingSection){
        $controller = "";
        $name = "";
        $action = "";
        $arguments = [];
        if (isset($routingSection["controller"])) {
            $controller .= $routingSection["controller"];
        }
        if (isset($routingSection["name"])) {
            $name .= $routingSection["name"];
        }
        if (isset($routingSection["action"])) {
            $action .= $routingSection["action"];
        }
        if (isset($routingSection["argument"])) {
            foreach ($routingSection["argument"] as $arg) {
                $arguments[] = $arg;
            }
        }
        return array($controller, $name, $action, $arguments);
    }

    /**
     * @param $cacheFilePath String : path of the cache file to create
     *
     * Create the cache file with path passed in argument
     */
    private function createCacheFile($cacheFilePath){
        $cacheFile = fopen($cacheFilePath, "w") or die("Unable to create file ".$cacheFilePath);
        fclose($cacheFile);
    }

    /**
     * @param $cacheFilePath String : path of the cache file to create
     * @param $text String : content to write in the file
     *
     * Writes content in the cache file specified
     */
    private function writeInCacheFile($cacheFilePath, $text){
        file_put_contents($cacheFilePath, $text);
    }



} 