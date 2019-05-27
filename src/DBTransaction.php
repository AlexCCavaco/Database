<?php

namespace DB;

class DBTransaction {

    protected $db;
    protected $ended = false;

    public function __construct(\PDO $db){
        $this->db = $db;
        $db->beginTransaction();
    }

    public function add(DBQueryBase $dbElement){
        return $dbElement->run($this->db);
    }

    /**
     * @param $table
     * @param string $alias
     * @return DBSelect
     */
    public function selectFrom($table,$alias=''){
        return (new DBSelect($this->db))::from($table,$alias);
    }

    /**
     * @param $table
     * @param string $alias
     * @return DBUpdate
     */
    public function updateTable($table,$alias=''){
        return (new DBUpdate($this->db))::table($table,$alias);
    }

    /**
     * @param $table
     * @param string $alias
     * @return DBInsert
     */
    public function insertInto($table,$alias=''){
        return (new DBInsert($this->db))::into($table,$alias);
    }

    /**
     * @param $table
     * @param string $alias
     * @return DBDelete
     */
    public function deleteFrom($table,$alias=''){
        return (new DBDelete($this->db))::from($table,$alias);
    }

    /**
     * @return bool
     */
    public function commit(){
        if($this->ended) return false;
        $this->ended = true;
        return $this->db->commit();
    }

    /**
     * @return bool
     */
    public function rollback(){
        if($this->ended) return false;
        $this->ended = true;
        return $this->db->rollBack();
    }

}
