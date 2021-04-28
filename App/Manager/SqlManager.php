<?php

class SqlManager {

    public const STATEMENT_DATA_NOT_FIND = 0;
    public const STATEMENT_DATA_FIND = 1;

    public const UNDIFINED_REQUEST = 0;
    public const REQUEST_WRITE = 1;
    public const REQUEST_GET = 2;
    public const REQUEST_SHOW = 3;

    public const NO_DATABASE = "";
    public const DATABASE_OLYMPUS = "olympus_db";

    public static function __init_all_tables(){
        $pdo = self::connectPDO(self::DATABASE_OLYMPUS);

        $pdo->prepare("CREATE TABLE IF NOT EXISTS `users`(
            id INT UNSIGNED AUTO_INCREMENT KEY,
            pseudo VARCHAR(255),
            password VARCHAR(255),
            email VARCHAR(255)
        )")->execute();
        $pdo->prepare("CREATE TABLE IF NOT EXISTS `messages`(
            id INT UNSIGNED AUTO_INCREMENT KEY,
            author VARCHAR(255),
            content VARCHAR(255)
        )")->execute();
        $pdo->prepare("CREATE TABLE IF NOT EXISTS `private_messages`(
            id INT UNSIGNED AUTO_INCREMENT KEY,
            author VARCHAR(255),
            recipient VARCHAR(255),
            content VARCHAR(255)
        )")->execute();
        $pdo->prepare("CREATE TABLE IF NOT EXISTS `connected`(
            name VARCHAR(255)
        )")->execute();
    }

    /**
     * @return stdClass
     */
    protected static function serialize_sql_data() : stdClass {
        return json_decode(file_get_contents(__DIR__ . '/../../settings/sql-ids.json'));
    }

    /**
     * @param null $dbName
     *
     * @return PDO
     */
    public static function connectPDO($dbName = null) : PDO {
        $data = self::serialize_sql_data();

        if (is_null($dbName)) {
            return new PDO("{$data->host}:host={$data->config_type}", $data->username, $data->password);
        } else return new PDO("{$data->host}:host={$data->config_type};dbname=$dbName", $data->username, $data->password);
    }

    /**
     * @param string $statement
     *
     * @param string $db
     *
     * @param array|null $bindValues
     */
    public static function writeData(string $statement, string $db, array $bindValues = null){
        $pdo = self::connectPDO($db);

        if (!is_null($bindValues)){
            $sql = $pdo->prepare($statement);
            $sql->execute($bindValues);
        } else $pdo->exec($statement);
    }

    /**
     * @param string $statement
     *
     * @param string $db
     *
     * @param null|array $bindValues
     *
     * @return bool
     */
    public static function dataExist(string $statement, string $db, array $bindValues = null) : bool {
        $pdo = self::connectPDO($db);
        $sql = $pdo->prepare($statement);

        if (!is_null($bindValues)){
            $sql->execute($bindValues);
        } else $sql->execute();
        return $sql->rowCount() >= self::STATEMENT_DATA_FIND;
    }

    /**
     * @param string $statement
     *
     * @param string $db
     *
     * @return mixed
     */
    public static function getData(string $statement, string $db = ""){
        if ($db === "") $pdo = self::connectPDO();
        else $pdo = self::connectPDO($db);

        $pdo = self::connectPDO($db);
        $sql = $pdo->prepare($statement);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $statement
     *
     * @return int
     */
    public static function determinate_sql_request_type(string $statement) : int {
        if (strpos($statement, "SELECT") === false) {} else {
            return self::REQUEST_GET;
        } if ((strpos($statement, "INSERT INTO") === false) and (strpos($statement, "DROP") === false) and (strpos($statement, "DELETE") === false) and (strpos($statement, "UPDATE") === false)) {} else {
            return self::REQUEST_WRITE;
        } if (strpos($statement, "SHOW") === false) {} else {
            return self::REQUEST_SHOW;
        }
        return SqlManager::UNDIFINED_REQUEST;
    }
}