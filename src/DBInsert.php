<?php

namespace App\lib\Database;

/**
 * Class DBSelect
 * @package App\lib\Database
 */
class DBInsert {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var DBList
     */
    protected $cols;
    /**
     * @var DBParamList
     */
    protected $vals;
    /**
     * @var DBFields
     */
    protected $duplicate;

    /**
     * DBSelect constructor.
     * @param string $table
     * @param string $alias
     */
    public function __construct($table,$alias=''){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->cols = new DBList();
        $this->vals = new DBParamList();
        $this->duplicate = new DBFields();
    }

    /**
     * @param string $table
     * @param string $alias
     * @return static
     */
    public static function into($table,$alias=''){
        return new static($table,$alias);
    }

    /**
     * @param array $cols
     * @return $this
     */
    public function columns(array $cols){
        $this->cols->addArray($cols);
        return $this;
    }

    /**
     * @param array $vals
     * @param array $params
     * @return $this
     */
    public function values(array $vals,array $params=[]){
        $this->vals->addArray($vals,$params);
        return $this;
    }

    /**
     * @param string $col
     * @param string $val
     * @param null $param
     * @param bool $onDup
     * @return $this
     */
    public function colAndVal(string $col,string $val='?',$param=null,$onDup=false){
        $this->cols->add($col);
        $this->vals->add($val,$param);
        if($onDup) $this->duplicate->set($col,'VALUES('.$col.')');
        return $this;
    }

    /**
     * @return string
     */
    public function query(){
        $q = 'INSERT INTO '.$this->table.' ('.$this->cols->query().') VALUES ('.$this->vals->query().')';
        if($this->duplicate->query()!=='') $q.= ' ON DUPLICATE KEY UPDATE '.$this->duplicate->query();
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        return array_merge($this->vals->params(),$this->duplicate->params());
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
