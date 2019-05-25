<?php

namespace Database;

use Database\lib\DBCriteria;
use Database\lib\DBFields;
use Database\traits\PrepRunTrait;
use Database\traits\WhereTrait;

class DBUpdate implements DBQueryBase {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var DBFields
     */
    protected $set;
    /**
     * @var string
     */
    protected $returning;

    /**
     * DBSelect constructor.
     * @param string $table
     * @param string $alias
     */
    public function __construct($table,$alias=''){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->set = new DBFields();
        $this->where = new DBCriteria();
        $this->returning = '';
    }

    /**
     * @param string $table
     * @param string $alias
     * @return static
     */
    public static function table($table,$alias=''){
        return new static($table,$alias);
    }

    /**
     * @param string $column
     * @param string $equal
     * @param array|string $param
     * @return $this
     */
    public function set(string $column,string $equal='?',$param=[]){
        $this->set->set($column,$equal,$param);
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setAll(array $values=[]){
        $this->set->setAll($values);
        return $this;
    }

    /**
     * @param DBFields $fields
     * @return $this
     */
    public function setAssign(DBFields $fields){
        $this->set = $fields;
        return $this;
    }

    use WhereTrait;

    /**
     * @param string $returning
     * @return $this
     */
    public function returning($returning){
        $this->returning = $returning;
        return $this;
    }

    /**
     * @return string
     */
    public function query(){
        $q = 'UPDATE '.$this->table.' SET '.$this->set->query().' WHERE '.$this->where->query();
        if($this->returning!=='') $q.= ' RETURNING '.$this->returning;
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        return array_merge($this->set->params(),$this->where->params());
    }

    use PrepRunTrait;

}
