<?php

namespace Database;

use Database\lib\DBCriteria;
use Database\lib\DBJoinChain;
use Database\lib\DBList;
use Database\traits\HavingTrait;
use Database\traits\PrepRunTrait;
use Database\traits\WhereTrait;

class DBSelect implements DBQueryBase {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var DBList
     */
    protected $select;
    /**
     * @var DBJoinChain
     */
    protected $joins;
    /**
     * @var DBList
     */
    protected $group;
    /**
     * @var DBList
     */
    protected $order;
    /**
     * @var string|int
     */
    protected $limit;

    /**
     * DBSelect constructor.
     * @param string $table
     * @param string $alias
     */
    public function __construct($table,$alias=''){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->select = new DBList();
        $this->joins = new DBJoinChain();
        $this->where = new DBCriteria();
        $this->group = new DBList();
        $this->having = new DBCriteria();
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

    /**
     * @param string $column
     * @param string $alias
     * @param array $params
     * @return $this
     */
    public function select($column,$alias='',$params=[]){
        if($alias!=='') $column.= ' AS '.$alias;
        $this->select->add($column);
        if(!empty($params)) $this->select->addParams($params);
        return $this;
    }

    /**
     * @param array $columns
     * @param string $table_alias
     * @param string $prefix_alias
     * @return $this
     */
    public function selectAll($columns,$table_alias='',$prefix_alias=''){
        if($table_alias!=='') $table_alias.='.';
        foreach($columns as $sec1=>$sec2){
            if(is_string($sec1)){
                $col = $table_alias.$sec1;
            } else {
                $col = $table_alias.$sec2;
            }
            $alias = $prefix_alias.$sec2;
            $this->select($col,$alias);
        }
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria $on
     * @param string $type
     * @return $this
     */
    public function join($table,$alias='',DBCriteria $on,$type=''){
        $this->joins->join($table,$alias,$on,$type);
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function leftJoin($table,$alias='',DBCriteria $on){
        $this->joins->leftJoin($table,$alias,$on);
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function rightJoin($table,$alias='',DBCriteria $on){
        $this->joins->rightJoin($table,$alias,$on);
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function fullJoin($table,$alias='',DBCriteria $on){
        $this->joins->fullJoin($table,$alias,$on);
        return $this;
    }

    /**
     * @param string|DBSelect $select
     * @param string $alias
     * @param DBCriteria $on
     * @param array $params
     * @param string $type
     * @return $this
     */
    public function joinSelect($select,$alias='',DBCriteria $on,array $params=[],string $type=''){
        $this->joins->selectJoin($select,$alias,$on,$params,$type);
        return $this;
    }

    use WhereTrait;

    /**
     * @param array|string $var
     * @return $this
     */
    public function orderBy($var){
        if(is_string($var)) $this->order->add($var);
        else $this->order->addAll($var);
        return $this;
    }

    use HavingTrait;

    /**
     * @param array|string $var
     * @return $this
     */
    public function groupBy($var){
        if(is_string($var)) $this->group->add($var);
        $this->group->addAll($var);
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
        $q = 'SELECT '.$this->select->query().' FROM '.$this->table.'';
        if($this->joins->query()!=='') $q.= ' '.$this->joins->query();
        if($this->where->query()!=='') $q.= ' WHERE '.$this->where->query();
        if($this->group->query()!=='') $q.= ' GROUP BY '.$this->group->query();
        if($this->having->query()!=='') $q.= ' HAVING '.$this->having->query();
        if($this->order->query()!=='') $q.= ' ORDER BY '.$this->order->query();
        if($this->limit!=='') $q.= ' LIMIT '.$this->limit;
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        return array_merge($this->select->params(),$this->joins->params(),$this->where->params(),$this->group->params(),$this->having->params());
    }

    use PrepRunTrait;

}
