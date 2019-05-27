<?php

namespace Database;

use Database\lib\DBCriteria;
use Database\lib\DBList;
use Database\traits\LimitTrait;
use Database\traits\OrderByTrait;
use Database\traits\PrepRunTrait;
use Database\traits\WhereTrait;

class DBDelete implements DBQueryBase {

    /**
     * @var string
     */
    protected $table;

    /**
     * @param string $table
     * @param string $alias
     */
    public function __construct($table,$alias=''){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->where = new DBCriteria();
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

    use WhereTrait;

    use OrderByTrait;

    use LimitTrait;

    /**
     * @return string
     */
    public function query(){
        $q = 'DELETE FROM '.$this->table.' WHERE '.$this->where->query();
        if($this->order!=='') $q.= ' ORDER BY '.$this->order->query();
        if($this->limit!=='') $q.= ' LIMIT '.$this->limit;
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        return $this->where->params();
    }

    use PrepRunTrait;

}
