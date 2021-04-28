<?php

require_once "App/Autoloader.php";
__load_all_classes();

class AdminTools {

    public const ADMIN_ACCOUNT_ID = 1;

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
        switch ($request_type) {
            case SqlManager::UNDIFINED_REQUEST:
                return "Undifined request";
                break;
            case SqlManager::REQUEST_WRITE:
                SqlManager::writeData($statement, SqlManager::DATABASE_OLYMPUS);
                return "Data has been writed in the database";
                break;
            case SqlManager::REQUEST_GET:
                return Utils::array_to_string(SqlManager::getData($statement, SqlManager::DATABASE_OLYMPUS));
                break;
            case SqlManager::REQUEST_SHOW:
                return Utils::array_to_string(SqlManager::getData($statement, SqlManager::NO_DATABASE));
                break;
        }
        return false;
    }
}