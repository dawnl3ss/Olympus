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
        switch ($request_type) {
            case SqlManager::REQUEST_WRITE:
                SqlManager::writeData($statement, SqlManager::DATABASE_OLYMPUS);
                return "Data has been writed in the database";
                break;
            case SqlManager::REQUEST_GET:
                return self::array_to_string(SqlManager::getData($statement, SqlManager::DATABASE_OLYMPUS));
                break;
        }
        return false;
    }

    /**
     * @param array $arr
     */
    public static function array_to_string(array $arr){
        $string_array = "";
        $assoc_index = 0;

        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $string_array .= "{$assoc_index} => {" . "<br>";
                $assoc_index++;

                foreach ($value as $key1 => $value1) {
                    if (is_array($value1)) {} else {
                        $string_array .= "    {$key1} => {$value1}," . "<br>";
                    }
                }
            } else {
                $string_array .= "{$key} => {$value}," . "<br>";
            }
        }
        return $string_array;
    }
}