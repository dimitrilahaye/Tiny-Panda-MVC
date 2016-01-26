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
     * Generates the cache file for the route
     */
    private function createRouteCacheFile(){
        $tinyDir = new TinyDirectory();
        $cacheDir = $tinyDir->getCacheDir(__DIR__);
        if(!file_exists($cacheDir)) {
            mkdir($cacheDir);
            $routeCacheFilePath = $cacheDir . DIRECTORY_SEPARATOR . "routeCache.ini";
            $this->createCacheFile($routeCacheFilePath);
            $fileIni = $tinyDir->getConfigFile(__DIR__, 'routing.ini');
            if ($fileIni != null) {
                $routingIni = parse_ini_file($fileIni, true);
                $text = "";
                $lib = "";
                $controller = "";
                $name = "";
                $action = "";
                $argument = "";
                foreach ($routingIni as $key => $value) {
                    $lib .= $key;
                    if (isset($value["controller"])) {
                        $controller .= $value["controller"];
                    }
                    if (isset($value["name"])) {
                        $name .= $value["name"];
                    }
                    if (isset($value["action"])) {
                        $action .= $value["action"];
                    }
                    if (isset($value["argument"])) {
                        $argument .= $value["argument"];
                    }
                    $text .= "\n[" . $name . "]\n";
                    $text .= "controller = " . $controller . "\n";
                    $text .= "action = " . $action . "\n";
                    $text .= "route = " . $lib . "\n";
                    if ($argument != "") {
                        $text .= "argument = " . $argument . "\n";
                    }
                    $lib = "";
                    $controller = "";
                    $name = "";
                    $action = "";
                    $argument = "";
                }
                $this->writeInCacheFile($routeCacheFilePath, $text);

            } else {
                throw new Exception('Unable to find or read routing.ini...');
            }
        }
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