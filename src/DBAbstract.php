<?php

namespace App\lib\Database;

/**
 * Class DBAbstract
 * Used on DB* Classes
 * @package App\lib\Database
 */
abstract class DBAbstract {

    /**
     * Query String
     * @var string
     */
    protected $query = '';

    /**
     * Parameter for Query
     * @var array
     */
    protected $params = [];

    /**
     * Returns the Query String
     * @return string
     */
    public function query():string { return $this->query; }

    /**
     * Returns the Parameter Array
     * @return array
     */
    public function params():array { return $this->params; }

    /**
     * Adds a value to Parameters
     * @param $param
     */
    public function addParam($param){
        $this->params[] = $param;
    }

    /**
     * Adds values to Parameters
     * @param array $params
     */
    public function addParams(array $params){
        foreach($params as $param) $this->params[] = $param;
    }

    /**
     * @param array $arr
     * @return string
     */
    protected function formatArray(array $arr){
        $data = '';
        foreach($arr as $elm)
            $data.= ($data===''?'':',').$elm;
        return $data;
    }

}
