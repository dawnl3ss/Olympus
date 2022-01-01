<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/Autoloader.php";
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
    public function get_recipient() : string {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function format_string() : string {
        return "<p class='private-message'>    <bold>{$this->author}</bold>  ->  {$this->message} </p>";
    }

    /**
     * @return MessageHandler
     */
    public function delete_message() : MessageHandler {
        SQLManager::write_data("DELETE FROM `private_messages` WHERE id = '{$this->id}'", SQLManager::DATABASE_OLYMPUS);
        return $this;
    }

    /**
     * @param string $new
     *
     * @return MessageHandler
     */
    public function edit_message(string $new) : MessageHandler {
        SQLManager::write_data("UPDATE `private_messages`
            SET content = '{$new}'
            WHERE id = '{$this->id}'
        ", SQLManager::DATABASE_OLYMPUS);
        return $this;
    }
}