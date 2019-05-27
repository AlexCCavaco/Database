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
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @param string $type
     * @return self
     */
    public static function start(string $table,$alias='',$on=null,$params=null,string $type=''):self {
        return (new self())->join($table,$alias,$on,$params,$type);
    }

    /**
     * Adds one Left Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @return self
     */
    public function leftJoin(string $table,$alias='',$on=null,$params=null):self {
        return $this->join($table,$alias,$on,$params,'LEFT');
    }

    /**
     * Adds one Right Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @return self
     */
    public function rightJoin(string $table,$alias='',$on=null,$params=null):self {
        return $this->join($table,$alias,$on,$params,'RIGHT');
    }

    /**
     * Adds one Full Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @return self
     */
    public function fullJoin(string $table,$alias='',$on=null,$params=null):self {
        return $this->join($table,$alias,$on,$params,'FULL');
    }

    /**
     * Adds one Join Element
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @param string $type
     * @return self
     */
    public function join(string $table,$alias,$on=null,$params=null,string $type=''):self {
        $this->query.= " $type JOIN $table AS $alias ON ";
        if(!is_null($on)){
            if(is_a($on,DBCriteria::class)) $this->query.= $on->query();
            else $this->query.= $on;
        } else $this->query.= '1';
        $args = $on->params();
        if(!is_null($on)){
            if(is_array($params)) $args = array_merge($params,$args);
            else $args[] = $params;
        }
        $this->addParams($args);
        return $this;
    }

    /**
     * Adds one Left Join Element for a Select Query
     * @param string|DBSelect $select
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @param string $type
     * @return self
     */
    public function selectJoin($select,$alias,$on=null,$params=null,string $type=''):self {
        if(is_a($select,DBSelect::class)){
            $params = array_merge($select->params(),$params);
            $select = $select->query();
        }
        return $this->join('('.$select.')',$alias,$on,$params,$type);
    }

}
