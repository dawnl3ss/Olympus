<?php

require_once "App\Autoloader.php";
__load_all_classes();

class MessageHandler {

    /** @var array $messages */
    public static $messages = [];

    /** @var string $message */
    public $message;

    /** @var string $author */
    public $author;

    /** @var int $id */
    public $id;

    public function __construct(string $message, string $author, int $id){
        $this->message = $message;
        $this->author = $author;
        $this->id = $id;
    }

    public static function __init_messages(){
        self::$messages = [];

        foreach (SqlManager::getData("SELECT * FROM `messages` ORDER BY `id`", SqlManager::DATABASE_OLYMPUS) as $key => $data){
            array_push(self::$messages, new Message($data["content"], $data["author"], $data["id"]));
        }
    }

    /**
     * @param TempUser $asker
     */
    public static function __init_private_messages(TempUser $asker){
        $asker->conversations = [];

        foreach (SqlManager::getData("SELECT * FROM `private_messages` WHERE author = '{$asker->getUsername()}' OR recipient = '{$asker->getUsername()}' ORDER BY `id`", SqlManager::DATABASE_OLYMPUS) as $key => $data){
            array_push($asker->conversations, new PrivateMessage($data["content"], $data["author"], $data["id"], $data["recipient"]));
        }
    }

    /**
     * @return string
     */
    public function format_string() : string {
        return "<p class='chat-message'>    {$this->author}  |  {$this->message} </p>";
    }

    /**
     * @return $this
     */
    public function delete_message() : self {
        if (in_array($this, self::$messages, true)){
            SqlManager::writeData("DELETE FROM `messages` WHERE id = '{$this->id}'", SqlManager::DATABASE_OLYMPUS);
        }
        return $this;
    }

    /**
     * @param string $new
     *
     * @return $this
     */
    public function edit_message(string $new) : self {
        SqlManager::writeData("UPDATE `messages`
            SET content = '{$new}' 
            WHERE id = '{$this->id}'
        ", SqlManager::DATABASE_OLYMPUS);
        return $this;
    }
}