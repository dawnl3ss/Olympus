<?php

class SessionManager {

    /** @var array $data */
    public $data;

    /** @var bool $admin */
    public $admin;

    public function __construct(array $data, bool $admin = false){
        $this->data = $data;
        $this->admin = $admin;
    }

    /**
     * @param $session
     *
     * @return bool
     */
    public static function is_registered($session) : bool {
        return isset($session["data"]);
    }

    /**
     * @param $session_var
     */
    public function refresh_data($session_var){
        $session_var["data"] = $this->data;
        return $this;
    }

    /**
     * @param $d_name
     *
     * @param $d_value
     */
    public function put_data($d_name, $d_value){
        $this->data[$d_name] = $d_value;
        return $this;
    }

    /**
     * @param $d_key
     */
    public function remove_data($d_key){
        unset($this->data[array_search($d_key, $this->data)]);
        return $this;
    }

    /**
     * @param $d_key
     *
     * @return mixed
     */
    public function get_data($d_key){
        return $this->data[$d_key];
    }

    /**
     * @return array
     */
    public function get_all_data() : array {
        return $this->data;
    }
}