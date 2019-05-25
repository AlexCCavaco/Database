<?php

namespace App\lib\Database;

class DBCriteriaOpr {

    private $criteria;

    public function __construct(DBCriteria $criteria){
        $this->criteria = $criteria;
    }

    public function equal(string $col,$param=null){
        return $this->buildBasicOperand($col,$param,'=');
    }

    public function notEqual(string $col,$param=null){
        return $this->buildBasicOperand($col,$param,'!=');
    }

    public function greaterThan(string $col,$param=null){
        return $this->buildBasicOperand($col,$param,'>');
    }

    public function smallerThan(string $col,$param=null){
        return $this->buildBasicOperand($col,$param,'<');
    }

    public function greaterOrEqualThan(string $col,$param=null){
        return $this->buildBasicOperand($col,$param,'>=');
    }

    public function smallerOrEqualThan(string $col,$param=null){
        return $this->buildBasicOperand($col,$param,'<=');
    }

    public function isNull(){
        $this->criteria->query.= 'IS NULL ';
        return $this->criteria;
    }

    public function isNotNull(){
        $this->criteria->query.= 'IS NOT NULL ';
        return $this->criteria;
    }

    public function between(string $coll,string $col2,$param1=null,$param2=null){
        $this->buildBasicOperand($coll,$param1,'BETWEEN ');
        return $this->buildBasicOperand($col2,$param2,'AND ');
    }

    public function notBetween(string $coll,string $col2,$param1=null,$param2=null){
        $this->buildBasicOperand($coll,$param1,'NOT BETWEEN ');
        return $this->buildBasicOperand($col2,$param2,'AND ');
    }

    public function in(array $cols,array $params){
        $this->criteria->query.= "IN ".$this->formatArray($cols);
        $this->criteria->addParams($params);
        return $this->criteria;
    }

    public function notIn(array $cols,array $params){
        $this->criteria->query.= "NOT IN ".$this->formatArray($cols);
        $this->criteria->addParams($params);
        return $this->criteria;
    }

    /**
     * Formats an Array to a string version with the values separated with commas
     * @param array $values
     * @return string
     */
    protected function formatArray(array $values){
        $r = ''; foreach($values as $val) $r.= (empty($r)?'':',').$val;
        return $r;
    }

    /**
     * An helpful function to ease operand handling
     * @param string $col
     * @param null $param
     * @param $opr
     * @return DBCriteria
     */
    private function buildBasicOperand(string $col,$param=null,$opr){
        if($param===null) $this->criteria->query.= "$opr $col ";
        else {
            $this->criteria->query.= "$opr ? ";
            $this->criteria->addParam($param);
        }
        return $this->criteria;
    }

}
