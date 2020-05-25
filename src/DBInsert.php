<?php

namespace DB;

use DB\lib\DBFields;
use DB\lib\DBList;
use DB\lib\DBParamList;
use DB\traits\PrepRunTrait;

class DBInsert implements DBQueryBase {

    /**
     * @var string
     */
    protected $table;

    /**
     * @var bool
     */
    protected $ignore;
    /**
     * @var DBList
     */
    protected $cols;
    /**
     * @var DBParamList
     */
    protected $values;
    /**
     * @var DBFields
     */
    protected $duplicate;

    /**
     * DBSelect constructor.
     * @param string $table
     * @param string $alias
     */
    public function __construct($table,$alias=''){
        if($alias!=='') $table.= ' AS '.$alias;
        $this->table = $table;

        $this->ignore = false;
        $this->cols = new DBList();
        $this->values = new DBParamList();
        $this->duplicate = new DBFields();
    }

    /**
     * @param string $table
     * @param string $alias
     * @return static
     */
    public static function into($table,$alias=''){
        return new static($table,$alias);
    }

    /**
     * @return $this
     */
    public function ignore(){
        $this->ignore = true;
        return $this;
    }

    /**
     * @param string $col
     * @param $param
     * @param bool $onDup
     * @return $this
     */
    public function value($col,$param,$onDup=false){
        $this->cols->add($col);
        $this->values->add('?',$param);
        if($onDup) $this->duplicate->set($col,'VALUES('.$col.')');
        return $this;
    }

    /**
     * @param array $values
     * @param bool $onDup
     * @return $this
     */
    public function values(array $values,$onDup=false){
        foreach($values as $k=>$value) $this->value($k,$value,$onDup);
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function onDupKey(array $data){
        $this->duplicate->setAll($data);
        return $this;
    }

    /**
     * @return string
     */
    public function query(){
        $q = 'INSERT '.($this->ignore?'IGNORE ':'').'INTO '.$this->table.' ('.$this->cols->query().') VALUES ('.$this->values->query().')';
        if($this->duplicate->query()!=='') $q.= ' ON DUPLICATE KEY UPDATE '.$this->duplicate->query();
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        return array_merge($this->values->params(),$this->duplicate->params());
    }

    use PrepRunTrait;

}
