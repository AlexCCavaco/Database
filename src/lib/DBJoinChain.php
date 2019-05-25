<?php

namespace Database\lib;

use Database\DBSelect;

class DBJoinChain extends DBAbstract {

    /**
     * DBJoinChain constructor.
     */
    public function __construct(){}

    /**
     * Adds one Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|null $on
     * @param array $params
     * @param string $type
     * @return self
     */
    public static function start(string $table,string $alias,?DBCriteria $on=null,array $params=[],string $type=''):self {
        return (new self())->join($table,$alias,$on,$params,$type);
    }

    /**
     * Adds one Left Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|null $on
     * @param array $params
     * @return self
     */
    public function leftJoin(string $table, string $alias, ?DBCriteria $on=null, array $params=[]):self {
        return $this->join($table,$alias,$on,$params,'LEFT');
    }

    /**
     * Adds one Right Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|null $on
     * @param array $params
     * @return self
     */
    public function rightJoin(string $table, string $alias, ?DBCriteria $on=null, array $params=[]):self {
        return $this->join($table,$alias,$on,$params,'RIGHT');
    }

    /**
     * Adds one Full Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|null $on
     * @param array $params
     * @return self
     */
    public function fullJoin(string $table,string $alias,?DBCriteria $on=null,array $params=[]):self {
        return $this->join($table,$alias,$on,$params,'FULL');
    }

    /**
     * Adds one Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|null $on
     * @param array $params
     * @param string $type
     * @return self
     */
    public function join(string $table,string $alias,?DBCriteria $on=null,array $params=[],string $type=''):self {
        $this->query.= " $type JOIN $table AS $alias ON ";
        if(!is_null($on)) $this->query.= $on->query();
        else $this->query.= '1';
        $this->addParams(array_merge($params,$on->params()));
        return $this;
    }

    /**
     * Adds one Left Join Element for a Select Query
     * @param string|DBSelect $select
     * @param string $alias
     * @param DBCriteria|null $on
     * @param array $params
     * @param string $type
     * @return self
     */
    public function selectJoin($select,string $alias,?DBCriteria $on=null,array $params=[],string $type=''):self {
        if(is_a($select,DBSelect::class)){
            $params = array_merge($select->params(),$params);
            $select = $select->query();
        }
        return $this->join('('.$select.')',$alias,$on,$params,$type);
    }

}
