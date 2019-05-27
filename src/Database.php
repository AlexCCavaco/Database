<?php

namespace DB;

use Psr\Log\LoggerInterface;

/**
 * Class Database
 * The classes is an utility front to the normal PDO class.
 * Many functions work as a query builder.
 * @package Database
 */
class Database extends \PDO {

    /** @var null|LoggerInterface */
    private $logger = null;

    /** @var string */
    private $logType = 'debug';

    /**
     * Database constructor
     * @param $host
     * @param $database
     * @param $username
     * @param $password
     * @param string $charset='utf8'
     * @param string $timezone='UTC'
     */
    public function __construct($host,$database,$username,$password,$charset='utf8',$timezone='+00:00'){
        parent::__construct('mysql:host='.$host.';dbname='.$database.';charset='.$charset,$username,$password,[\PDO::MYSQL_ATTR_INIT_COMMAND=>"SET time_zone = '$timezone'"]);
        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * Sets Statement Log
     * @param LoggerInterface $logger
     * @param string $logType
     * @throws \Exception
     */
    public function logStatements(LoggerInterface $logger,$logType='debug'){
        if(!method_exists($logger,$logType)) throw new \Exception('Log Type is Invalid!');
        $this->logger = $logger;
        $this->logType = $logType;
    }

    /**
     * Prepares and Executes Query
     * @param string $statement
     * @param array $params=null
     * @param array $driverOptions=[]
     * @return \PDOStatement|false
     */
    public function prepRun($statement,array $params=null,array $driverOptions=[]){
        if($this->logger!==null) ($this->logger->{$this->logType})($statement,$params);
        $q = $this->prepare($statement,$driverOptions);
        if($q===false||$q->execute($params)===false) return false;
        return $q;
    }

}
