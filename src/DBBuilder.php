<?php

namespace DB;

class DBBuilder {

    /**
     * @param $table
     * @param string $alias
     * @return DBSelect
     */
    public static function selectFrom($table,$alias=''){
        return DBSelect::from($table,$alias);
    }

    /**
     * @param $table
     * @param string $alias
     * @return DBUpdate
     */
    public static function updateTable($table,$alias=''){
        return DBUpdate::table($table,$alias);
    }

    /**
     * @param $table
     * @param string $alias
     * @return DBInsert
     */
    public static function insertInto($table,$alias=''){
        return DBInsert::into($table,$alias);
    }

    /**
     * @param $table
     * @param string $alias
     * @return DBDelete
     */
    public static function deleteFrom($table,$alias=''){
        return DBDelete::from($table,$alias);
    }

    /**
     * @param callable $queries
     * @param \PDO $db
     * @return bool
     */
    public static function transaction(callable $queries,\PDO $db){
        $transaction = new DBTransaction($db);
        try {
            $queries($transaction);
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollback();
            return false;
        }
        return true;
    }

}
