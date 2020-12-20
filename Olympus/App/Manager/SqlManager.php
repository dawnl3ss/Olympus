<?php

class SqlManager {

    public const STATEMENT_DATA_NOT_FIND = 0;
    public const STATEMENT_DATA_FIND = 1;

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
    public static function writeData(string $data, string $db, $query = false, $bindValues = array()){
        $pdo = self::connectPDO($db);

        if (!$query){
            $pdo->exec($data);
        } else {
            $sql = $pdo->prepare($data);
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
    public static function dataExist(string $data, string $db, $bindValues = null) : bool {
        $pdo = self::connectPDO($db);
        $sql = $pdo->prepare($data);
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
    public static function getData(string $statement, string $db){
        $pdo = self::connectPDO($db);
        $sql = $pdo->prepare($statement);
        $sql->execute();
        return $sql->fetchAll();
    }
}