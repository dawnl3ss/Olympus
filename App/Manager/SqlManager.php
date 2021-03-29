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

    /** @var string $username */
    private static $username = "root";

    /** @var string $password */
    private static $password = "";

    /**
     * @return string
     */
    protected static function getUsername() : string {
        return self::$username;
    }

    /**
     * @return string
     */
    protected static function getPassword() : string {
        return self::$password;
    }

    /**
     * @param null $dbName
     *
     * @return PDO
     */
    public static function connectPDO($dbName = null) : PDO {
        if (is_null($dbName)) {
            return new PDO("mysql:host=localhost", self::getUsername(), self::getPassword());
        } else {
            return new PDO("mysql:host=localhost;dbname=$dbName", self::getUsername(), self::getPassword());
        }
    }

    /**
     * @param string $data
     *
     * @param string $db
     *
     * @param bool $query
     *
     * @param null $bindValues
     */
    public static function writeData(string $statement, string $db, $query = false, $bindValues = array()){
        $pdo = self::connectPDO($db);

        if (!$query){
            $pdo->exec($statement);
        } else {
            $sql = $pdo->prepare($statement);
            $sql->execute($bindValues);
        }
    }

    /**
     * @param string $data
     *
     * @param string $db
     *
     * @return bool
     */
    public static function dataExist(string $statement, string $db, $bindValues = null) : bool {
        $pdo = self::connectPDO($db);
        $sql = $pdo->prepare($statement);
        $sql->execute();
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