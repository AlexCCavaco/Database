<?php

namespace Database\traits;

use Database\lib\DBCriteria;

/**
 * Trait for DB Where Functions
 * --
 * Class WhereTrait
 * @package App\lib\Database\traits
 */
trait HavingTrait {

    /**
     * @var DBCriteria
     */
    protected $having;

    /**
     * @param string $col
     * @param $arg
     * @return $this
     */
    public function having(string $col,$arg=null) {
        $this->having->and($col,$arg);
        return $this;
    }

    /**
     * @param string $col
     * @param $arg
     * @return $this
     */
    public function andHaving(string $col,$arg=null) {
        $this->having->and($col,$arg);
        return $this;
    }

    /**
     * @param string $col
     * @param $arg
     * @return $this
     */
    public function orHaving(string $col,$arg=null) {
        $this->having->or($col,$arg);
        return $this;
    }

    /**
     * @param DBCriteria $or
     * @return $this
     */
    public function groupHaving(DBCriteria $or){
        $this->having->andGroup($or);
        return $this;
    }

    /**
     * @param DBCriteria $or
     * @return $this
     */
    public function andGroupHaving(DBCriteria $or){
        $this->having->andGroup($or);
        return $this;
    }

    /**
     * @param DBCriteria $or
     * @return $this
     */
    public function orGroupHaving(DBCriteria $or){
        $this->having->orGroup($or);
        return $this;
    }

}
