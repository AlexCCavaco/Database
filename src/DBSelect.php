<?php

namespace DB;

use DB\lib\DBCriteria;
use DB\lib\DBJoinChain;
use DB\lib\DBList;
use DB\traits\HavingTrait;
use DB\traits\JoinTrait;
use DB\traits\LimitTrait;
use DB\traits\OrderByTrait;
use DB\traits\PrepRunTrait;
use DB\traits\WhereTrait;

class DBSelect implements DBQueryBase {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $inherited;
    /**
     * @var DBList
     */
    protected $select;
    /**
     * @var DBList
     */
    protected $group;

    /**
     * DBSelect constructor.
     * @param string $table
     * @param string $alias
     * @param array $params
     */
    public function __construct($table,$alias='',$params=[]){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->inherited = $params;
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
     * Select Query From Another Select
     * @param DBSelect $select
     * @param string $alias
     * @return static
     */
    public static function fromSelect(DBSelect $select,$alias=''){
        $new = new static("(".$select->query().")",$alias);
        $new->inherited = $select->params();
        return $new;
    }

    /**
     * Automatically Sets Select all Where id is equal $id
     * @param string|int $id
     * @return static
     */
    public function find($id){
        $this->select('*');
        $this->where('id = ?',$id);
        return $this;
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
     * @param string|array ...$columns
     * @return $this
     */
    public function selectAll(...$columns){
        foreach($columns as $col){
            if(is_array($col)) foreach($col as $val) $this->select($val);
            else $this->select($col);
        }
        return $this;
    }

    /**
     * @param array $columns
     * @param string $table_alias
     * @param string $prefix_alias
     * @return $this
     */
    public function selectAllAliased($columns,$table_alias='',$prefix_alias=''){
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

    use JoinTrait;

    use WhereTrait;

    use OrderByTrait;

    use HavingTrait;

    /**
     * @param array|string ...$vars
     * @return $this
     */
    public function groupBy(...$vars){
        foreach($vars as $var){
            if(is_array($var)) $this->group->addAll($var);
            else $this->group->add($var);
        }
        return $this;
    }

    use LimitTrait;

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
        return array_merge($this->inherited,$this->select->params(),$this->joins->params(),$this->where->params(),$this->group->params(),$this->having->params());
    }

    use PrepRunTrait;

}
