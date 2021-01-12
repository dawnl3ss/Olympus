<?php

require_once "App/Manager/SqlManager.php";

class AdminTools {

    public const ADMIN_ACCOUNT_ID = 21;

    /**
     * @param string $statement
     *
     * @return string|null
     */
    public static function apply_shell_command(string $statement){
        return shell_exec($statement);
    }

    /**
     * @param string $statement
     *
     * @param int $request_type
     *
     * @return bool|mixed|void
     */
    public static function apply_sql_command(string $statement, int $request_type){
        switch ($request_type){
            case SqlManager::REQUEST_WRITE:
                return SqlManager::writeData($statement, SqlManager::DATABASE_OLYMPUS);
                break;
            case SqlManager::REQUEST_GET:
                return SqlManager::getData($statement, SqlManager::DATABASE_OLYMPUS);
                break;
        }
        return false;
    }
}