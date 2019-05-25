<?php

namespace Database;

use Database\lib\DBCriteria;
use Database\lib\DBList;
use Database\traits\WhereTrait;

class DBDelete implements DBQueryBase {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var DBList
     */
    protected $order;
    /**
     * @var string|int
     */
    protected $limit;

    /**
     * @param string $table
     * @param string $alias
     */
    public function __construct($table,$alias=''){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->where = new DBCriteria();
        $this->order = new DBList();
        $this->limit = '';
    }

    /**
     * @param string $table
     * @param string $alias
     * @return static
     */
    public static function from($table,$alias=''){
        return new static($table,$alias);
    }

    use WhereTrait;

    /**
     * @param array|string $var
     * @return $this
     */
    public function orderBy(array $var){
        if(is_string($var)) $this->order->add($var);
        $this->order->addAll($var);
        return $this;
    }

    /**
     * @param string|int $limit
     * @return $this
     */
    public function limit($limit){ $this->limit = $limit; return $this; }

    /**
     * @return string
     */
    public function query(){
        $q = 'DELETE FROM '.$this->table.' WHERE '.$this->where->query();
        if($this->order!=='') $q.= ' ORDER BY '.$this->order->query();
        if($this->limit!=='') $q.= ' LIMIT '.$this->limit;
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        return $this->where->params();
    }

    /**
     * Preps and Runs Query
     * @param Database $db
     * @return false|\PDOStatement
     */
    public function run(Database $db){
        return $db->prepRun($this->query(),$this->params());
    }

}
