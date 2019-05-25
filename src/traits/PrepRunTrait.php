<?php

namespace App\lib\Database\traits;
use Psr\Log\LoggerInterface;

/**
 * Qu
 * @package App\lib\Database\traits
 */
trait PrepRunTrait {

    /**
     * Prepares and Executes Query
     * @param string $statement
     * @param array $params=null
     * @param array $driverOptions=[]
     * @return \PDOStatement|false
     */
    public function prepRun(string $statement,array $params=null,array $driverOptions=[]){
        if($this->logger!==null) ($this->logger->{$this->logType})($statement,$params);
        $q = $this->prepare($statement,$driverOptions);
        if($q===false||$q->execute($params)===false) return false;
        return $q;
    }

}
