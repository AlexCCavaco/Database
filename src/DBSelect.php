<?php

namespace App\lib\Database;

/**
 * Class DBSelect
 * @package App\lib\Database
 */
class DBSelect {

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
     * @var DBCriteria
     */
    protected $where;
    /**
     * @var DBList
     */
    protected $group;
    /**
     * @var DBCriteria
     */
    protected $having;
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
    public function join($table,$alias='',DBCriteria $on,$type='LEFT'){
        return $this->dirJoin($table,$alias,$on,$type);
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function joinLeft($table,$alias='',DBCriteria $on){
        return $this->join($table,$alias,$on,'LEFT');
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function joinRight($table,$alias='',DBCriteria $on){
        return $this->join($table,$alias,$on,'RIGHT');
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function joinFull($table,$alias='',DBCriteria $on){
        return $this->join($table,$alias,$on,'FULL');
    }

    /**
     * @param DBSelect $select
     * @param string $alias
     * @param DBCriteria $on
     * @param string $type
     * @return $this
     */
    public function joinS(DBSelect $select,$alias='',DBCriteria $on,$type='LEFT'){
        return $this->dirJoin('('.$select->query().')',$alias,$on,$type,$select->params());
    }

    /**
     * @param DBSelect $select
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function joinSLeft(DBSelect $select,$alias='',DBCriteria $on){
        return $this->joinS($select,$alias,$on,'LEFT');
    }

    /**
     * @param DBSelect $select
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function joinSRight(DBSelect $select,$alias='',DBCriteria $on){
        return $this->joinS($select,$alias,$on,'RIGHT');
    }

    /**
     * @param DBSelect $select
     * @param string $alias
     * @param DBCriteria $on
     * @return $this
     */
    public function joinSFull(DBSelect $select,$alias='',DBCriteria $on){
        return $this->joinS($select,$alias,$on,'FULL');
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria $on
     * @param string $type
     * @param array $params
     * @return $this
     */
    protected function dirJoin($table,$alias='',DBCriteria $on,$type='LEFT',array $params=[]){
        $this->joins->join($table,$alias,$on,$params,$type);
        return $this;
    }

    /**
     * @param string $col
     * @param string $opr
     * @param string $val
     * @param string|null $arg1
     * @param string|null $arg2
     * @return $this
     */
    public function where($col,$opr,$val='?',$arg1=null,$arg2=null){
        $this->where->and($col,$opr,$val,$arg1,$arg2);
        return $this;
    }

    /**
     * @param string $col
     * @param string $opr
     * @param string $val
     * @param string|null $arg1
     * @param string|null $arg2
     * @return $this
     */
    public function or($col,$opr,$val='?',$arg1=null,$arg2=null){
        $this->where->or($col,$opr,$val,$arg1,$arg2);
        return $this;
    }

    /**
     * @param DBCriteria $and
     * @return $this
     */
    public function andWhere(DBCriteria $and){
        $this->where->andX($and); return $this;
    }

    /**
     * @param DBCriteria $or
     * @return $this
     */
    public function orWhere(DBCriteria $or){
        $this->where->orX($or); return $this;
    }


    /**
     * @param array|string $var
     * @return $this
     */
    public function orderBy($var){
        if(is_string($var)) $this->order->add($var);
        else $this->order->addArray($var);
        return $this;
    }

    /**
     * @param string $col
     * @param string $opr
     * @param string $val
     * @param string|null $arg1
     * @param string|null $arg2
     * @return $this
     */
    public function having($col,$opr,$val='?',$arg1=null,$arg2=null){
        $this->having->and($col,$opr,$val,$arg1,$arg2);
        return $this;
    }

    /**
     * @param DBCriteria $and
     * @return $this
     */
    public function andHaving(DBCriteria $and){
        $this->having->andX($and);
        return $this;
    }

    /**
     * @param DBCriteria $or
     * @return $this
     */
    public function orHaving(DBCriteria $or){
        $this->having->orX($or);
        return $this;
    }

    /**
     * @param array|string $var
     * @return $this
     */
    public function groupBy(array $var){
        if(is_string($var)) $this->group->add($var);
        $this->group->addArray($var);
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

    /**
     * Preps and Runs Query
     * @param Database $db
     * @return false|\PDOStatement
     */
    public function run(Database $db){
        return $db->prepRun($this->query(),$this->params());
    }

}
