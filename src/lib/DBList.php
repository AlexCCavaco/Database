<?php

namespace Database\lib;

class DBList extends DBAbstract {

    /**
     * DBList constructor.
     */
    public function __construct(){}

    /**
     * Add a value to the list
     * @param string $val
     * @return self
     */
    public static function value(string $val):self {
        return (new self())->add($val);
    }

    /**
     * Add an array of values to the list
     * @param array $values
     * @return self
     */
    public static function all(array $values):self {
        return (new self())->addAll($values);
    }

    /**
     * Add a value to the list
     * @param string $val
     * @return self
     */
    public function add(string $val):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= $val;
        return $this;
    }

    /**
     * Add an array of values to the list
     * @param array $values
     * @return self
     */
    public function addAll(array $values):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= $this->formatArray($values);
        return $this;
    }

    /**
     * Add a value to the list
     * @param string $val
     * @return self
     */
    public function addDesc(string $val):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= $val.' DESC';
        return $this;
    }

    /**
     * Add an array of values to the list
     * @param array $values
     * @return self
     */
    public function addDescAll(array $values):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= $this->formatArray($values).' DESC';
        return $this;
    }

    /**
     * Add an array of values to the list with a common alias
     * @param array $select
     * @param string $alias
     * @return self
     */
    public function bindAliases(array $select, string $alias):self {
        foreach($select as $var) $this->add("$alias.$var AS ".strtolower($alias)."_$var");
        return $this;
    }

}