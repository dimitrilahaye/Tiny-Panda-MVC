<?php
namespace Tiny\Manager;
Use PDO;
Use Exception;

/**
 * Class TinyPDO
 * @package Tiny\Persistence
 *
 * Provides methods to make SQL operations
 */
class TinyPDO extends PDO{

    /**
     * @var string
     *
     * Path to Tiny/Configuration/db.ini
     */
    protected $fileIni;

    /*
        insert : post("panda", array("name"=>"Toto", "weight"=>3.5));
        update : put("panda", 12, array("name"=>"Toto", "weight"=>3.5));
        delete : delete("panda", 12);
    */

    public function __construct(){
        $tinyDir = new TinyDirectory();
        $this->fileIni = $tinyDir->getConfigFile(__DIR__, 'db.ini');
        if($this->fileIni != null){
            $dbIni = parse_ini_file($this->fileIni, true);
            $driver = $dbIni['database']['driver'];
            $host = $dbIni['database']['host'];
            $port = empty($dbIni['database']['port']) ? $dbIni['database']['port'] : '';
            $dbname = $dbIni['database']['dbname'];
            $username = $dbIni['database']['username'];
            $password = $dbIni['database']['password'];
            $dns = $driver.':dbname='.$dbname.';host='.$host.';port='.$port;
            parent::__construct($dns, $username, $password);
        } else {
            throw new Exception('Unable to find or read '.$this->fileIni.'...');
        }
    }
}