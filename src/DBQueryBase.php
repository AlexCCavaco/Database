<?php

namespace Database;

interface DBQueryBase {

    /**
     * @return string
     */
    public function query();

    /**
     * @return array
     */
    public function params();

    /**
     * Preps and Runs Query
     * @param Database $db
     * @return false|\PDOStatement
     */
    public function run(Database $db);

}
