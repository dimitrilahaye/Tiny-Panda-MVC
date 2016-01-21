<?php

namespace Tiny\Handler;

/**
 * Class DirectoryHandler
 * @package Tiny\Handler
 *
 * Provides methods to find files in Project or Tiny directory
 */
class DirectoryHandler {

    /**
     * @param $directory
     * @param $file
     * @return string
     *
     * Returns configuration file $file
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
     * @return string
     *
     * Returns Configuration directory
     */
    public static function getConfigDir($directory){
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
    public static function getCacheDir($directory){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.'Cache';
    }

    /**
     * @param $directory
     * @param $target
     * @return string
     *
     * Returns directory $target in Project folder
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
     * @return string
     *
     * Returns directory $target in Tiny folder
     */
    public static function getTinyDir($directory, $target){
        $dir = explode(DIRECTORY_SEPARATOR, $directory);
        array_pop($dir);
        $dir = implode(DIRECTORY_SEPARATOR, $dir);
        return $dir.DIRECTORY_SEPARATOR.$target.'/';
    }
}