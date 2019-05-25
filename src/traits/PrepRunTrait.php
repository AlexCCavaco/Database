<?php

namespace Database\traits;
use Database\Database;

/**
 * Trait for DB Run Function
 * --
 * Class WhereTrait
 * @package App\lib\Database\traits
 */
trait PrepRunTrait {

    /**
     * Preps and Runs Query
     * @param \PDO $db
     * @param array $driverOptions
     * @return false|\PDOStatement
     */
    public function run(\PDO $db,$driverOptions=[]){
        if($db instanceof Database) return $db->prepRun($this->query(),$this->params(),$driverOptions);
        $q = $db->prepare($this->query(),$driverOptions);
        if($q===false||$q->execute($this->params())===false) return false;
        return $q;
    }

}
