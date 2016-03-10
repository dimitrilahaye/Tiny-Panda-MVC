<?php

namespace Tiny\Manager;

/**
 * Class which provides the settings of the Tiny Panda Application :
 * Debug mode, etc.
 */
class TinySettings {
    
    /**
     * @throws Exception
     * 
     * Parses the settings.ini file then launches the configuration for the Tiny Panda Application.
     */
    public function initSettings(){
        $tinyDir = new TinyDirectory();
        $settingsFile = $tinyDir->getSettingsIni();
        if(file_exists($settingsFile)){
            $fileIni = parse_ini_file($settingsFile, true);
            $this->checkDebugSettings($fileIni);
        } else{
            throw new \Exception("Can't find ". $settingsFile);
        }
    }
    
    /**
     * @param type String $fileIni : the path to the settings.ini file
     * @throws Exception
     *
     * Enable debug mode as configured in the settings.ini file.
     */
    private function checkDebugSettings($fileIni){
        if(isset($fileIni["debug"])){
            if(isset($fileIni["debug"]["enable"])){
                if($fileIni["debug"]["enable"]){
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                }
            } else{
            throw new \Exception("The enable element for the debug section can't be found in Tiny/Configuration/settings.ini");
            }
        } else {
            throw new \Exception("The debug section can't be found in Tiny/Configuration/settings.ini");
        }
    }
    
}
