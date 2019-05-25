<?php

namespace App\lib\Database;

/**
 * Class DBFields
 * Formats Database x=y fields
 * @package App\lib\Database
 */
class DBFields extends DBAbstract {

    /**
     * DBFields constructor.
     */
    public function __construct(){}

    /**
     * Adds a x=y field and creates an instance
     * @param string $var
     * @param string $eql
     * @param array|string $args
     * @return self
     */
    public static function n(string $var, string $eql='', array $args=[]):self {
        return (new self())->set($var,$eql,$args);
    }

    /**
     * Equivalent to n for multiple values at once
     * @param array $vals=[]
     * @param array|string $args
     * @return self
     */
    public static function a(array $vals=[], array $args=[]):self {
        return (new self())->setX($vals,$args);
    }

    /**
     * Adds a x=y field
     * @param string $var
     * @param string $eql
     * @param array|string $args
     * @return self
     */
    public function set(string $var, string $eql='', $args=[]):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= "$var = $eql";
        if(!is_array($args)&&!is_null($args)) $this->params[] = $args;
        elseif(!empty($args)) $this->addParams($args);
        return $this;
    }

    /**
     * Equivalent to set for multiple values at once
     * @param array $vals=[]
     * @param array|string $args
     * @return self
     */
    public function setX(array $vals=[], $args=[]):self {
        foreach($vals as $var=>$eql) $this->set($var,$eql);
        if(!is_array($args)&&!is_null($args)) $this->params[] = $args;
        elseif(!empty($args)) $this->addParams($args);
        return $this;
    }

}
