<?php

namespace DB;

use DB\lib\DBCriteria;
use DB\lib\DBFields;
use DB\lib\DBJoinChain;
use DB\lib\DBList;
use DB\traits\JoinTrait;
use DB\traits\LimitTrait;
use DB\traits\OrderByTrait;
use DB\traits\PrepRunTrait;
use DB\traits\WhereTrait;

class DBUpdate implements DBQueryBase {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var DBFields
     */
    protected $set;
    /**
     * @var string
     */
    protected $returning;

    /**
     * DBSelect constructor.
     * @param string $table
     * @param string $alias
     */
    public function __construct($table,$alias=''){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->set = new DBFields();
        $this->where = new DBCriteria();
        $this->joins = new DBJoinChain();
        $this->order = new DBList();
        $this->limit = '';
        $this->returning = '';
    }

    /**
     * @param string $table
     * @param string $alias
     * @return static
     */
    public static function table($table,$alias=''){
        return new static($table,$alias);
    }

    /**
     * @param string $column
     * @param string $equal
     * @param array|mixed $param
     * @return $this
     */
    public function set(string $column,string $equal='?',$param=null){
        $this->set->set($column,$equal,$param);
        return $this;
    }

    /**
     * @param array|string $values
     * @return $this
     */
    public function setAll(...$values){
        foreach($values as $val){
            if(is_array($val)) $this->set->setAll($val);
            else $this->set->set($val);
        }
        return $this;
    }

    /**
     * @param DBFields $fields
     * @return $this
     */
    public function setAssign(DBFields $fields){
        $this->set = $fields;
        return $this;
    }

    use WhereTrait;

    use JoinTrait;

    use OrderByTrait;

    use LimitTrait;

    /**
     * @param string $returning
     * @return $this
     */
    public function returning($returning){
        $this->returning = $returning;
        return $this;
    }

    /**
     * @return string
     */
    public function query(){
        $q = 'UPDATE '.$this->table;
        if($this->joins->query()!=='') $q.= ' '.$this->joins->query();
        $q.= ' SET '.$this->set->query().' WHERE '.$this->where->query();
        if($this->order->query()!=='') $q.= ' ORDER BY '.$this->order->query();
        if($this->limit!=='') $q.= ' LIMIT '.$this->limit;
        if($this->returning!=='') $q.= ' RETURNING '.$this->returning;
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        return array_merge($this->joins->params(),$this->set->params(),$this->where->params());
    }

    use PrepRunTrait;

}
