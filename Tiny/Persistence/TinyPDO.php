<?php
namespace Tiny\Persistence;
Use PDO;
Use Exception;
Use Tiny\Handler\DirectoryHandler;

class TinyPDO extends PDO{
    protected $fileIni;

    public function __construct(){
        $this->fileIni = DirectoryHandler::getConfigFile(__DIR__, 'db.init');
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