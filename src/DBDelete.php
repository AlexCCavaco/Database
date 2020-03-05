<?php

namespace DB;

use DB\lib\DBCriteria;
use DB\lib\DBList;
use DB\traits\LimitTrait;
use DB\traits\OrderByTrait;
use DB\traits\PrepRunTrait;
use DB\traits\WhereTrait;
use DB\traits\JoinTrait;

class DBDelete implements DBQueryBase {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var DBList
     */
    protected $delete;

    /**
     * @var bool
     */
    protected $joined;

    /**
     * @param string $table
     * @param string $alias
     */
    public function __construct($table,$alias=''){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->where = new DBCriteria();
        $this->order = new DBList();
        $this->delete = new DBList();
        $this->joined = false;
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
     * @param string $table_or_alias
     * @return self
     */
    public function delete($table_or_alias){
        $this->delete->add($table_or_alias);
        return $this;
    }

    use WhereTrait;

    use OrderByTrait;

    use JoinTrait;

    use LimitTrait;

    /**
     * @return string
     */
    public function query(){
        $q = 'DELETE '.$this->delete->query().' FROM '.$this->table;
        if($this->joins->query()!=='') $q.= ' '.$this->joins->query();
        $q.= ' WHERE '.$this->where->query();
        if($this->order->query()!=='') $q.= ' ORDER BY '.$this->order->query();
        if($this->limit!=='') $q.= ' LIMIT '.$this->limit;
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        return array_merge($this->joins->params(),$this->where->params());
    }

    use PrepRunTrait;

}
