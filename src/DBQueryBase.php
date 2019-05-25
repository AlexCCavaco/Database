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
     * @param \PDO $db
     * @param array $driverOptions
     * @return false|\PDOStatement
     */
    public function run(\PDO $db,$driverOptions=[]);

}
