<?php

class SQLManager {

    public const DATABASE_OLYMPUS = "olympus_db";
    public const STATEMENT_DATA_FIND = 1;

    /**
     * @param string $db
     *
     * @return MySQLi
     */
    public static function connect_sql(string $db) : MySQLi {
        return new \MySQLi("p:127.0.0.1", "root", "root", $db);
    }


    /**
     * @param string $statement
     *
     * @param string $db
     *
     * @param array $bind_param
     */
    public static function write_data(string $statement, string $db) : void {
        self::connect_sql($db)->query($statement);
    }
    /**
     * @param string $statement
     *
     * @param string $db
     *
     * @param array $bind_param
     *
     * @return bool
     */
    public static function data_exist(string $statement, string $db) : bool {
        $sql = self::connect_sql($db)->query($statement);
        return $sql->num_rows >= self::STATEMENT_DATA_FIND;
    }

    /**
     * @param string $statement
     *
     * @param string $db
     *
     * @param array $bind_param
     *
     * @return array|null
     *
     */
    public static function get_data(string $statement, string $db) {
        $db = self::connect_sql($db);
        $sql = $db->query($statement);
        return $sql->fetch_all(MYSQLI_ASSOC);
    }
}