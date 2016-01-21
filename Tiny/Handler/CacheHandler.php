<?php

namespace Tiny\Handler;

use \Exception;


class CacheHandler {

    public static function initCacheFiles(){
        self::createRouteCacheFile();
    }

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

    private function createCacheFile($cacheFileName){
        $cacheFile = fopen($cacheFileName, "w") or die("Unable to create file ".$cacheFileName);
        fclose($cacheFile);
    }

    private function writeInCacheFile($cacheFileName, $text){
        file_put_contents($cacheFileName, $text);
    }



} 