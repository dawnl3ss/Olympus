<?php

$file_lists = [
    $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/manager/SQLManager.php",
    $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/security/BcryptHash.php",
    $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/struct/message/BanWord.php",
    $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/struct/message/MessageHandler.php",
    $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/struct/message/Message.php",
    $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/struct/message/PrivateMessage.php",
    $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/struct/user/User.php",
];

function __load_all_classes(){
    global $file_lists;
    foreach ($file_lists as $path) __load_class($path);
}

/**
 * @param string $class
 */
function __load_class(string $class){
    require_once $class;
}
