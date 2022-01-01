<?php

/**
 * @param string $text
 *
 * @return bool
 */
function contain_forbidden_word(string $text) : bool {
    $ban_words = [];

    foreach ($ban_words as $f_word){
        if (strpos($text, $f_word) === false){} else {
            return true;
        }
    }
    return false;
}