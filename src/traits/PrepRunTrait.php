<?php

namespace DB\traits;
use DB\Database;

/**
 * Trait for DB Run Function
 * --
 * Class WhereTrait
 * @package App\lib\Database\traits
 */
trait PrepRunTrait {

    /**
     * Preps and Runs Query
     * @param \PDO|null $db
     * @param array $driverOptions
     * @return false|\PDOStatement
     */
    public function run(\PDO $db=null,$driverOptions=[]){
        if(is_null($db)){
            if(is_null($this->db)) return false;
            else $db = $this->db;
        }
        if($db instanceof Database) return $db->prepRun($this->query(),$this->params(),$driverOptions);
        $q = $db->prepare($this->query(),$driverOptions);
        if($q===false||$q->execute($this->params())===false) return false;
        return $q;
    }

}
