<?php

require_once "App/Autoloader.php";
__load_all_classes();

class PrivateMessage extends Message {

    /** @var string $recipient */
    public $recipient;

    public function __construct(string $message, string $author, int $id, string $recipient){
        parent::__construct($message, $author, $id);
        $this->recipient = $recipient;
    }

    /**
     * @return string
     */
    public function getRecipient() : string {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function format_string() : string {
        return "<p class='private-message'>    {$this->author}  |  {$this->message} -> {$this->recipient}</p>";
    }

    /**
     * @return MessageHandler
     */
    public function delete_message() : MessageHandler {
        SqlManager::writeData("DELETE FROM `private_messages` WHERE id = '{$this->id}'", SqlManager::DATABASE_OLYMPUS);
        return $this;
    }

    /**
     * @param string $new
     *
     * @return MessageHandler
     */
    public function edit_message(string $new) : MessageHandler {
        SqlManager::writeData("UPDATE `private_messages`
            SET content = '{$new}' 
            WHERE id = '{$this->id}'
        ", SqlManager::DATABASE_OLYMPUS);
        return $this;
    }
}