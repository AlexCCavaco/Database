<?php

namespace Database\lib;

class DBFields extends DBAbstract {

    public function __construct(){}

    /**
     * Adds a x=y field and creates an instance
     * @param string $var
     * @param string $eql
     * @param array|string $params
     * @return self
     */
    public static function val(string $var, string $eql='',array $params=[]):self {
        return (new self())->set($var,$eql,$params);
    }

    /**
     * Equivalent to n for multiple values at once
     * @param array $values=[]
     * @return self
     */
    public static function all(array $values=[]):self {
        return (new self())->setAll($values);
    }

    /**
     * Adds a x=y field
     * @param string $var
     * @param string $eql
     * @param array|mixed $params
     * @return self
     */
    public function set(string $var, string $eql='',$params=null):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= "$var = $eql";
        if(!is_null($params)) {
            if (!is_array($params)) $this->params[] = $params;
            elseif (!empty($params)) $this->addParams($params);
        }
        return $this;
    }

    /**
     * Equivalent to set for multiple values at once
     * @param array $values=[]
     * @return self
     */
    public function setAll(array $values=[]):self {
        foreach($values as $var=>$eql) $this->set($var,'?',$eql);
        return $this;
    }

    /**
     * Equivalent to set for multiple values at once
     * @param array $values=[]
     * @param array|string $params
     * @return self
     */
    public function setAllDirect(array $values=[],$params=[]):self {
        foreach($values as $var=> $eql) $this->set($var,$eql);
        if(!is_array($params)&&!is_null($params)) $this->params[] = $params;
        elseif(!empty($params)) $this->addParams($params);
        return $this;
    }

}
