<?php

namespace Database\lib;

class DBFields extends DBAbstract {

    public function __construct(){}

    /**
     * Adds a x=y field and creates an instance
     * @param string $var
     * @param string $eql
     * @param array|string $args
     * @return self
     */
    public static function val(string $var, string $eql='', array $args=[]):self {
        return (new self())->set($var,$eql,$args);
    }

    /**
     * Equivalent to n for multiple values at once
     * @param array $values=[]
     * @param array|string $args
     * @return self
     */
    public static function all(array $values=[], array $args=[]):self {
        return (new self())->setAll($values,$args);
    }

    /**
     * Adds a x=y field
     * @param string $var
     * @param string $eql
     * @param array|string $args
     * @return self
     */
    public function set(string $var,string $eql='',$args=[]):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= "$var = $eql";
        if(!is_array($args)&&!is_null($args)) $this->params[] = $args;
        elseif(!empty($args)) $this->addParams($args);
        return $this;
    }

    /**
     * Equivalent to set for multiple values at once
     * @param array $values=[]
     * @param array|string $args
     * @return self
     */
    public function setAll(array $values=[],$args=[]):self {
        foreach($values as $var=> $eql) $this->set($var,$eql);
        if(!is_array($args)&&!is_null($args)) $this->params[] = $args;
        elseif(!empty($args)) $this->addParams($args);
        return $this;
    }

}
