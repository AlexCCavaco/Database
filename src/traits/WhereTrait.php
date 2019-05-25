<?php

namespace App\lib\Database\traits;

use App\lib\Database\DBCriteria;

/**
 * Class WhereTrait
 * @package App\lib\Database\traits
 */
trait WhereTrait {

    /**
     * @var DBCriteria
     */
    protected $where;

    /**
     * @param string $col
     * @param $arg
     * @return $this
     */
    public function where(string $col,$arg=null) {
        $this->where->and($col,$arg);
        return $this;
    }

    /**
     * @param string $col
     * @param $arg
     * @return $this
     */
    public function andWhere(string $col,$arg=null) {
        $this->where->and($col,$arg);
        return $this;
    }

    /**
     * @param string $col
     * @param $arg
     * @return $this
     */
    public function orWhere(string $col,$arg=null) {
        $this->where->or($col,$arg);
        return $this;
    }

    /**
     * @param DBCriteria $or
     * @return $this
     */
    public function groupWhere(DBCriteria $or){
        $this->where->andGroup($or);
        return $this;
    }

    /**
     * @param DBCriteria $or
     * @return $this
     */
    public function andGroupWhere(DBCriteria $or){
        $this->where->andGroup($or);
        return $this;
    }

    /**
     * @param DBCriteria $or
     * @return $this
     */
    public function orGroupWhere(DBCriteria $or){
        $this->where->orGroup($or);
        return $this;
    }

}
