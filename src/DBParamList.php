<?php

namespace App\lib\Database;

/**
 * Class DBParamList
 * Formats Database List Where Parameters are possible x,?,?,...
 * @package App\lib\Database
 */
class DBParamList extends DBAbstract {

    /**
     * DBParamList constructor.
     */
    public function __construct(){}

    /**
     * Add a value to the list
     * @param string $val
     * @param string|null $param
     * @return self
     */
    public static function n(string $val='?', string $param=null):self {
        return (new self())->add($val,$param);
    }

    /**
     * Add multiple values to the list
     * @param array $vals
     * @return self
     */
    public static function a(array $vals=[]):self {
        $criteria = new self();
        foreach($vals as $key=>$val){
            if($criteria->query!=='') $criteria->query.= ',';
            if(is_int($key)) $criteria->query.= $val;
            else {
                $criteria->query.= $key;
                $criteria->params[] = $val;
            }
        }
        return $criteria;
    }

    /**
     * Add a value to the list
     * @param string $val
     * @param null|string $param
     * @return self
     */
    public function add(string $val='?', ?string $param=null):self {
        if($this->query!=='') $this->query.= ',';
        $this->query.= $val;
        if(!is_null($param)) $this->params[] = $param;
        return $this;
    }

    /**
     * Add a value to the list
     * @param array $vals
     * @param null|array $params
     * @return self
     */
    public function addArray(array $vals, ?array $params=[]):self {
        foreach($vals as $val) $this->add($val);
        if(!is_null($params)) $this->addParams($params);
        return $this;
    }

}
