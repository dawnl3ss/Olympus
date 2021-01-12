<?php

class TempUser {

    /** @var array $data **/
    private $data;

    /** @var bool $connected_state */
    public $connected_state = false;
    
    public function __construct(array $data){
        $this->data = $data;
    }
    
    /**
     * @return string
     */
    public function getUsername() : string {
        return $this->data["username"];
    }
    
    /**
     * @return string
     */
    public function getPassword() : string {
        return $this->data["password"];
    }
    
    /**
     * @return int
     */
    public function getId() : int {
        return $this->data["id"];
    }

    /**
     * @return string
     */
    public function getMail() : string {
        return $this->data["email"];
    }

    /**
     * @return bool
     */
    public function isAdmin() : bool {
        return $this->data["admin"];
    }

    /**
     * @param string $index
     *
     * @param $value
     *
     * @return $this
     */
    public function update(string $index, $value) : self {
        SqlManager::writeData("UPDATE `users`
            SET $index = '$value'
            WHERE id = '{$this->getId()}'
        ", SqlManager::DATABASE_OLYMPUS);

        if ($index === "pseudo"){
            SqlManager::writeData("UPDATE `connected`
                SET name = '$value'
                WHERE name = '{$this->getUsername()}'
            ", SqlManager::DATABASE_OLYMPUS);
        }
        return $this;
    }

    /**
     * @param string $index
     *
     * @param $value
     */
    public function send_instance_content(string $index, $value){
        $this->data[$index] = $value;
    }

    public function connect(){
        $this->connected_state = true;
        SqlManager::writeData("INSERT INTO connected(
            name
        ) VALUES (
            '" . $this->getUsername() . "'
        )", SqlManager::DATABASE_OLYMPUS);
    }

    public function disconnect(){
        $this->connected_state = false;
        SqlManager::writeData("DELETE FROM `connected` WHERE
            `name` = '" . $this->getUsername() . "'",
        SqlManager::DATABASE_OLYMPUS);
    }
}