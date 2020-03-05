<?php
namespace DB\traits;

use DB\DBSelect;
use DB\lib\DBCriteria;
use DB\lib\DBJoinChain;

/**
 * Trait for DB Join Functions
 * --
 * Class JoinTrait
 * @package DB\traits
 */
trait JoinTrait {

    /**
     * @var DBJoinChain
     */
    protected $joins;

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @param string $type
     * @return $this
     */
    public function join($table,$alias='',$on=null,$params=null,$type=''){
        $this->joins->join($table,$alias,$on,$params,$type);
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @return $this
     */
    public function innerJoin($table,$alias='',$on=null,$params=null){
        $this->joins->innerJoin($table,$alias,$on,$params);
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @return $this
     */
    public function leftJoin($table,$alias='',$on=null,$params=null){
        $this->joins->leftJoin($table,$alias,$on,$params);
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @return $this
     */
    public function rightJoin($table,$alias='',$on=null,$params=null){
        $this->joins->rightJoin($table,$alias,$on,$params);
        return $this;
    }

    /**
     * @param string $table
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @return $this
     */
    public function fullJoin($table,$alias='',$on=null,$params=null){
        $this->joins->fullJoin($table,$alias,$on,$params);
        return $this;
    }

    /**
     * @param string|DBSelect $select
     * @param string $alias
     * @param DBCriteria|string|null $on
     * @param array|mixed|null $params
     * @param string $type
     * @return $this
     */
    public function joinSelect($select,$alias,$on,array $params=[],string $type=''){
        $this->joins->selectJoin($select,$alias,$on,$params,$type);
        return $this;
    }

}
