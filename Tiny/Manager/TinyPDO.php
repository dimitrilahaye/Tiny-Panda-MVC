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
class TinyPDO extends PDO implements TinyPersistenceInterface {

    /**
     * @var string
     *
     * Path to Tiny/Configuration/db.ini
     */
    protected $fileIni;

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
            parent::__construct($dns, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } else {
            throw new Exception('Unable to find or read '.$this->fileIni.'...');
        }
    }

    /*
    Override interface methods :
    */

    public function get($table, $filter){
        $return = [];
        List($where, $whereValues) = $this->manageWhereClause($filter);
        $stmt = $this->prepare("SELECT * FROM " . $table . " WHERE " . $where);
        $this->bindParams($stmt, $whereValues);
        $stmt->execute();
        while ($datas = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $return[] = $datas;
        }
        $stmt->closeCursor();
        return $return;
    }
    public function getAll($table){
        $return = [];
        $stmt = $this->query("SELECT * FROM " . $table);
        while ($datas = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $return[] = $datas;
        }
        $stmt->closeCursor();
        return $return;
    }
    public function post($table, $values){
        List($keys, $arrValues, $tokens) = $this->manageValues($values);
        $stmt = $this->prepare("INSERT INTO ". $table ." (". $keys .") VALUES (". $tokens .")");
        $this->bindParams($stmt, $arrValues);
        $stmt->execute();
        $stmt->closeCursor();
    }
    public function put($table, $values, $filter){
        $set = $this->manageSet($values);
        $setValues = [];
        foreach ($values as $key => $value) {
            $setValues[] = $value;
        }
        List($where, $whereValues) = $this->manageWhereClause($filter);
        for ($i=sizeof($setValues) - 1; $i >= 0; $i--) { 
            array_unshift($whereValues, $setValues[$i]);
        }
        $query = "UPDATE ". $table ." SET ". $set . " WHERE ". $where;
        $stmt = $this->prepare($query);
        $this->bindParams($stmt, $whereValues);
        $stmt->execute();
        $stmt->closeCursor();
    }
    public function putAll($table, $values){
        $set = $this->manageSet($values);
        $setValues = [];
        foreach ($values as $key => $value) {
            $setValues[] = $value;
        }
        $query = "UPDATE ". $table ." SET ". $set;
        $stmt = $this->prepare($query);
        $this->bindParams($stmt, $setValues);
        $stmt->execute();
        $stmt->closeCursor();
    }
    public function delete($table, $filter){
        List($where, $whereValues) = $this->manageWhereClause($filter);
        $stmt = $this->prepare("DELETE FROM " . $table . " WHERE " . $where);
        $this->bindParams($stmt, $whereValues);
        $stmt->execute();
        $stmt->closeCursor();
    }
    public function deleteAll($table){
        $stmt = $this->prepare("DELETE FROM " . $table);
        $stmt->execute();
        $stmt->closeCursor();
    }
    public function close($connection){
        $connection = null;
    }

    /**
    * @param Array $values parameters to perform in the query
    *
    * @return the fields to persist in database, the parameters for each field and the number of tokens
    */
    private function manageValues($values){
        $keys = "";
        $arrValues = [];
        $tokens = "";
        foreach ($values as $key => $value) {
            $keys .= $key.",";
            $arrValues[] = $value;
            $tokens .= "?,";
        }
        $keys = substr($keys, 0, -1);
        $tokens = substr($tokens, 0, -1);
        return array($keys, $arrValues, $tokens);
    }

    /**
    * @param Array $filter parameters to perform in the query
    *
    * @return the clause where
    */
    private function manageWhereClause($filter){
        $where = "";
        $whereValues = [];
        foreach ($filter as $key => $value) {
            $where .= $key . " = ? AND ";
            $whereValues[] = $value;
        }
        $where = substr($where, 0, -5);
        return array($where, $whereValues);
    }

    /**
    * @param Array $values parameters to perform in the query
    *
    * @return the SET part of the query
    */
    private function manageSet($values){
        $set = "";
        foreach ($values as $key => $value) {
            $set .= $key." = ?, ";
        }
        $set = substr($set, 0, -2);
        return $set;
    }

    /**
    * @param Array $values parameters to bind in the query
    *
    * Will perform the bindParam of the $stmt
    */
    private function bindParams($stmt, $values){
        for ($i=0; $i < sizeof($values); $i++) {
            $stmt->bindParam($i + 1, $values[$i]);
        }
    }
}