<?php

require_once "App/Handler/MessageHandler.php";

class Message extends MessageHandler {

    public function __construct(string $message, string $author, int $id){
        parent::__construct($message, $author, $id);
    }

    /**
     * @return string
     */
    public function getMessage() : string {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getAuthor() : string {
        return $this->author;
    }

    /**
     * @return int
     */
    public function getId() : int {
        return $this->id;
    }
}