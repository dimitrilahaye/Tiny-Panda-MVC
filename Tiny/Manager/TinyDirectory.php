<?php

namespace Tiny\Manager;

/**
 * Class TinyDirectory
 * @package Tiny\Manager
 *
 * Provides methods to find files in Project or Tiny directory
 */
class TinyDirectory {

    //TODO : refactor this class !!

    //TODO : finish actuals comments

    /**
     * @param $directory
     * @param $file
     * @return string
     *
     * Returns configuration file $file
     */
    public function getConfigFile($directory, $file){
        $fileIni = $this->getTinyDir($directory, 'Configuration').$file;
        if(file_exists($fileIni)) {
            return $fileIni;
        } else {
            return null;
        }
    }

    /**
     * @param $directory
     * @return string
     *
     * Returns Configuration directory
     */
    public function getConfigDir($directory){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.'Configuration';
    }

    /**
     * @param $directory
     * @return string
     *
     * Returns Cache directory
     */
    public function getCacheDir($directory){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.'Cache';
    }
    
    /**
     * @return String path to the routeCache.ini
     *
     * Returns path to the routeCache.ini files
     */
    public function getRouteCacheIni(){
        return $this->getCacheDir(__DIR__).DIRECTORY_SEPARATOR."routeCache.ini";
    }
    
    public function getSettingsIni(){
        return $this->getConfigDir(__DIR__).DIRECTORY_SEPARATOR."settings.ini";
    }

    /**
     * @param $directory
     * @param $target
     * @return string
     *
     * Returns directory $target in Project folder
     */
    public function getProjectDir($directory, $target){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.'Project'.DIRECTORY_SEPARATOR.$target.DIRECTORY_SEPARATOR;
    }

    /**
     * @param $directory
     * @param $target
     * @return string
     *
     * Returns directory $target in Tiny folder
     */
    public function getTinyDir($directory, $target){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.$target.'/';
    }
}