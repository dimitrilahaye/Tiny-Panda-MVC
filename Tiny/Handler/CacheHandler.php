<?php

namespace Tiny\Handler;

use \Exception;

/**
 * Class CacheHandler
 * @package Tiny\Handler
 *
 * Provides methods to create cache files.
 */
class CacheHandler {

    /**
     * @throws Exception
     * Generates all the cache files
     */
    public static function initCacheFiles(){
        self::createRouteCacheFile();
    }

    /**
     * @throws Exception
     * Generates the cache file for the route
     */
    private function createRouteCacheFile(){
        $cacheDir = DirectoryHandler::getCacheDir(__DIR__);
        mkdir($cacheDir);
        $routeCacheFilePath = $cacheDir.DIRECTORY_SEPARATOR."routeCache.ini";
        self::createCacheFile($routeCacheFilePath);
        $fileIni = DirectoryHandler::getConfigFile(__DIR__, 'routing.init');
        if($fileIni != null) {
            $routingIni = parse_ini_file($fileIni, true);
            $text = "";
            $lib = "";
            $controller = "";
            $name = "";
            $action = "";
            $argument = "";
            foreach($routingIni as $key => $value){
                $lib .= $key;
                $controller .= $value["controller"];
                $name .= $value["name"];
                $action .= $value["action"];
                $argument .= $value["argument"];
                $text .= "\n[".$name."]\n";
                $text .= "controller = ".$controller."\n";
                $text .= "action = ".$action."\n";
                $text .= "route = ".$lib."\n";
                if($argument != "") {
                    $text .= "argument = ".$argument."\n";
                }
                $lib = "";
                $controller = "";
                $name = "";
                $action = "";
                $argument = "";
            }
            self::writeInCacheFile($routeCacheFilePath, $text);
        } else {
            throw new Exception('Unable to find or read routing.init...');
        }
    }

    /**
     * @param $cacheFilePath : path of the cache file to create
     * Create the cache file with path passed in argument
     */
    private function createCacheFile($cacheFilePath){
        $cacheFile = fopen($cacheFilePath, "w") or die("Unable to create file ".$cacheFilePath);
        fclose($cacheFile);
    }

    /**
     * @param $cacheFilePath : path of the cache file to create
     * @param $text : content to write in the file
     * Writes content in the cache file specified
     */
    private function writeInCacheFile($cacheFilePath, $text){
        file_put_contents($cacheFilePath, $text);
    }



} 