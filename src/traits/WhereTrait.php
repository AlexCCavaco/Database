<?php

namespace DB\traits;

use DB\lib\DBCriteria;

/**
 * Trait for DB Where Functions
 * --
 * Class WhereTrait
 * @package App\lib\Database\traits
 */
trait WhereTrait {

    /**
     * @var DBCriteria
     */
    protected $where;

    /**
     * @param string $colOprCol
     * @param $arg
     * @return $this
     */
    public function where(string $colOprCol,$arg=null){
        $this->where->andWhere($colOprCol,$arg);
        return $this;
    }

    /**
     * @param string $colOprCol
     * @param $arg
     * @return $this
     */
    public function andWhere(string $colOprCol,$arg=null){
        $this->where->andWhere($colOprCol,$arg);
        return $this;
    }

    /**
     * @param string $colOprCol
     * @param $arg
     * @return $this
     */
    public function orWhere(string $colOprCol,$arg=null){
        $this->where->orWhere($colOprCol,$arg);
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
