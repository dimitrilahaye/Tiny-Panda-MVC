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

    public function __construct(){
        $tinyDir = new TinyDirectory();
        $tinyDir->getConfigFile(__DIR__, 'db.ini');
        if($this->fileIni != null){
            $db_init = parse_ini_file($this->fileIni, true);
            $driver = $db_init['database']['driver'];
            $host = $db_init['database']['host'];
            $port = empty($db_init['database']['port']) ? $db_init['database']['port'] : '';
            $dbname = $db_init['database']['dbname'];
            $username = $db_init['database']['username'];
            $password = $db_init['database']['password'];
            $dns = $driver.':dbname='.$dbname.';host='.$host.';port='.$port;
            parent::__construct($dns, $username, $password);
        } else {
            throw new Exception('Unable to find or read '.$this->fileIni.'...');
        }
    }
}