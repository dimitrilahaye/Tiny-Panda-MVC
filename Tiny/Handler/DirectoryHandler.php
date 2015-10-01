<?php

namespace Tiny\Handler;


class DirectoryHandler {
    /**
     * @param $request
     * @return route without system directories
     */
    public static function getRoute($request){
        $url = $request['REQUEST_URI'];
        $dir = $request['SCRIPT_NAME'];
        $url = rtrim(ltrim($url, '/'), '/');
        $dir = rtrim(ltrim($dir, '/'), '/');
        $dir = explode('/', $dir);
        array_pop($dir);
        $url = str_replace($dir, '', $url);
        $url = ltrim($url, '/');
        return $url;
    }

    /**
     * @param $directory
     * @param $file
     * @return configuration file $file
     */
    public static function getConfigFile($directory, $file){
        $fileIni = DirectoryHandler::getTinyDir($directory, 'Configuration').$file;
        if(file_exists($fileIni)) {
            return $fileIni;
        } else {
            return null;
        }
    }

    /**
     * @param $directory
     * @return Configuration directory
     */
    public static function getConfigDir($directory){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.'Configuration';
    }

    /**
     * @param $directory
     * @param $target
     * @return string : directory $target in Project folder
     */
    public static function getProjectDir($directory, $target){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.'Project'.DIRECTORY_SEPARATOR.$target.DIRECTORY_SEPARATOR;
    }

    /**
     * @param $directory
     * @param $target
     * @return directory $target in Tiny folder
     */
    public static function getTinyDir($directory, $target){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.$target.'/';
    }
}