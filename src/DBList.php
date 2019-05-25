<?php

namespace App\lib\Database;

/**
 * Class DBList
 * Formats Database List x,y,z,...
 * @package App\lib\Database
 */
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
    public static function n(string $val):self {
        return (new self())->add($val);
    }

    /**
     * Add an array of values to the list
     * @param array $vals
     * @return self
     */
    public static function a(array $vals):self {
        return (new self())->addArray($vals);
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
     * @param array $vals
     * @return self
     */
    public function addArray(array $vals):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= $this->formatArray($vals);
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
     * @param array $vals
     * @return self
     */
    public function addDescArray(array $vals):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= $this->formatArray($vals).' DESC';
        return $this;
    }

}