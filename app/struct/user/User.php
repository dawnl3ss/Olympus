<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/Autoloader.php";
__load_all_classes();

class User {

    /** @var array $data **/
    private $data;

    /** @var bool $connected_state */
    public $connected_state = false;

    /** @var PrivateMessage[] $conversations */
    public $conversations = [];

    public function __construct(array $data){
        $this->data = $data;
    }

    /**
     * @param $session
     *
     * @return bool
     */
    public static function is_login($session) : bool {
        return isset($session["user"]);
    }

    /**
     * @return string
     */
    public function get_username() : string {
        return $this->data["username"];
    }

    /**
     * @return string
     */
    public function get_password() : string {
        return $this->data["password"];
    }

    /**
     * @return int
     */
    public function get_id() : int {
        return $this->data["id"];
    }

    /**
     * @return string
     */
    public function get_mail() : string {
        return $this->data["email"];
    }

    /**
     * @return bool
     */
    public function is_admin() : bool {
        return $this->data["admin"];
    }

    /**
     * @return PrivateMessage[]
     */
    public function get_conversations() : array {
        return $this->conversations;
    }

    /**
     * @param string $index
     *
     * @param $value
     *
     * @return $this
     */
    public function update(string $index, $value) : self {
        SQLManager::write_data("UPDATE `users`
            SET $index = '$value'
            WHERE id = '{$this->get_id()}'
        ", SQLManager::DATABASE_OLYMPUS);

        if ($index === "pseudo"){
            SQLManager::write_data("UPDATE `connected`
                SET name = '$value'
                WHERE name = '{$this->get_username()}'
            ", SQLManager::DATABASE_OLYMPUS);
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
        if (!SQLManager::data_exist("SELECT * FROM `connected` WHERE name = '{$this->get_username()}'", SQLManager::DATABASE_OLYMPUS)){
            if (!$this->is_admin()){
                SQLManager::write_data("INSERT INTO connected(
                    name
                ) VALUES (
                    '" . $this->get_username() . "'
                )", SQLManager::DATABASE_OLYMPUS);
            }
        }
    }

    public function disconnect(){
        $this->connected_state = false;
        SQLManager::write_data("DELETE FROM `connected` WHERE
            `name` = '" . $this->get_username() . "'",
            SQLManager::DATABASE_OLYMPUS
        );
    }
}