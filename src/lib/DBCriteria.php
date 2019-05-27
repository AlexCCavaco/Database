<?php

namespace DB\lib;

class DBCriteria extends DBAbstract {

    public function __construct(){}

    /**
     * Quickstarts the Object win an And Criteria
     * @param string $col
     * @param $param
     * @return DBCriteriaOpr
     */
    public static function _and(string $col='?',$param=null):DBCriteriaOpr {
        return (new self())->and($col,$param);
    }

    /**
     * Quickstarts the Object win an Or Criteria
     * @param string $col
     * @param $param
     * @return DBCriteriaOpr
     */
    public static function _or(string $col='?',$param=null):DBCriteriaOpr {
        return (new self())->or($col,$param);
    }

    /**
     * Stars an And Criteria
     * @param string $colOprCol
     * @param $param
     * @return DBCriteria
     */
    public function andWhere(string $colOprCol,$param=null):DBCriteria {
        $this->query.= ($this->query!==''?' AND':'')." $colOprCol ";
        if($param!==null) $this->addParam($param);
        return $this;
    }

    /**
     * Stars an Or Criteria
     * @param string $colOprCol
     * @param null $param
     * @return DBCriteria
     */
    public function orWhere(string $colOprCol='?',$param=null):DBCriteria {
        $this->query.= ($this->query!==''?' OR':'')." $colOprCol ";
        if($param!==null) $this->addParam($param);
        return $this;
    }

    /**
     * Stars an And Criteria
     * @param string $col
     * @param $param
     * @return DBCriteriaOpr
     */
    public function and(string $col,$param=null):DBCriteriaOpr {
        $this->query.= ($this->query!==''?' AND':'')." $col ";
        if($param!==null) $this->addParam($param);
        return new DBCriteriaOpr($this);
    }

    /**
     * Stars an Or Criteria
     * @param string $col
     * @param null $param
     * @return DBCriteriaOpr
     */
    public function or(string $col='?',$param=null):DBCriteriaOpr {
        $this->query.= ($this->query!==''?' OR':'')." $col ";
        if($param!==null) $this->addParam($param);
        return new DBCriteriaOpr($this);
    }

    /**
     * Stars a new Object Instance with an And Criteria
     * @param DBCriteria $criteria
     * @return DBCriteria
     */
    public function andGroup(DBCriteria $criteria):DBCriteria {
        $this->query.= ($this->query!==''?' AND':'').' ('.$criteria->query().')';
        $this->addParams($criteria->params());
        return $this;
    }

    /**
     * Stars a new Object Instance with an Or Criteria
     * @param DBCriteria $criteria
     * @return DBCriteria
     */
    public function orGroup(DBCriteria $criteria):DBCriteria {
        $this->query.= ($this->query!==''?' OR':'').' ('.$criteria->query().')';
        $this->addParams($criteria->params());
        return $this;
    }

}
