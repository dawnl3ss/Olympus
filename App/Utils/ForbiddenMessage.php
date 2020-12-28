<?php

class ForbiddenMessage {

    /** @var array $words_list */
    private static $words_list = [
        "bitch"
    ];

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function contain_forbidden_word(string $text) : bool {
        foreach (self::$words_list as $f_word){
            if (strpos($text, $f_word) === false){} else {
                return true;
            }
        }
        return false;
    }
}