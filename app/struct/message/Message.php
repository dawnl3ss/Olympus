<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/Autoloader.php";
__load_all_classes();

class Message extends MessageHandler {

    public function __construct(string $message, string $author, int $id){
        parent::__construct($message, $author, $id);
    }

    /**
     * @return string
     */
    public function get_message() : string {
        return $this->message;
    }

    /**
     * @return string
     */
    public function get_author() : string {
        return $this->author;
    }

    /**
     * @return int
     */
    public function get_id() : int {
        return $this->id;
    }
}