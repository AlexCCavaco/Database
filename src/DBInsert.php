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
     * @var DBParamList[]
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
        $this->values = [new DBParamList()];
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
        $this->values[0]->add('?',$param);
        if($onDup) $this->duplicate->set($col,'VALUES('.$col.')');
        return $this;
    }

    /**
     * @param array $cols
     * @param array $multiValues
     * @return $this
     */
    public function multiValues(array $cols,array $multiValues,$onDup=false){
        foreach($cols as $col){
            if($onDup) $this->duplicate->set($col,'VALUES('.$col.')');
            $this->cols->add($col);
        }
        foreach($multiValues as $mValues) $this->addMultiValue($mValues);
        return $this;
    }

    /**
     * @param $values
     */
    private function addMultiValue($values){
        $plist = $this->values[0]->query()===''?$this->values[0]:($this->values[]=new DBParamList());
        foreach($values as $value) $plist->add('?',$value);
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
        $q = 'INSERT '.($this->ignore?'IGNORE ':'').'INTO '.$this->table.' ('.$this->cols->query().') VALUES ';
        if(count($this->values)>1) foreach($this->values as $k=>$val) $q.= ($k===0?'':',').'('.$val->query().')';
        else $q.= '('.$this->values[0]->query().')';
        if($this->duplicate->query()!=='') $q.= ' ON DUPLICATE KEY UPDATE '.$this->duplicate->query();
        return $q;
    }

    /**
     * @return array
     */
    public function params(){
        $a = [];
        if(count($this->values)>1) foreach($this->values as $k=>$value) $a = array_merge($a,$value->params());
        else $a = $this->values[0]->params();
        return array_merge($a,$this->duplicate->params());
    }

    use PrepRunTrait;

}
