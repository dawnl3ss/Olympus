<?php

include("StandartList.php");

class ARS_SHELL_CRYPT implements StandartList {

    public const METHOD_CRYPT = 0;
    public const METHOD_DECRYPT = 1;

    /**
     * @param string $f_char
     *
     * @return mixed|string
     */
    public function char_to_achar(string $f_char, int $method){
        $n_char = "";

        if ($method === self::METHOD_CRYPT) {
            for ($i = 0; $i <= (int)count(self::CHAR_LIST) - 1; $i++) {
                if (self::CHAR_LIST[$i] === $f_char) {
                    if ($i >= self::STANDART_SPACING) {
                        $find = false;
                        do {
                            if (isset(self::CHAR_LIST[$i + self::STANDART_SPACING])) {
                                $n_char = self::CHAR_LIST[$i + self::STANDART_SPACING];
                                break;
                            } elseif (isset(self::CHAR_LIST[($i + self::STANDART_SPACING) - count(self::CHAR_LIST)])) {
                                $n_char = self::CHAR_LIST[($i + self::STANDART_SPACING) - count(self::CHAR_LIST)];
                                break;
                            }
                        } while (!$find);
                        break;
                    } elseif ($i < self::STANDART_SPACING) {
                        $find = false;
                        do {
                            if (isset(self::CHAR_LIST[$i + self::STANDART_SPACING])) {
                                $n_char = self::CHAR_LIST[$i + self::STANDART_SPACING];
                                break;
                            }
                        } while (!$find);
                        break;
                    }
                }
            }
        } elseif ($method === self::METHOD_DECRYPT){
            for ($i = 0; $i <= (int)count(self::CHAR_LIST) - 1; $i++) {
                if (self::CHAR_LIST[$i] === $f_char) {
                    if ($i >= self::STANDART_SPACING) {
                        $find = false;
                        do {
                            if (isset(self::CHAR_LIST[$i - self::STANDART_SPACING])) {
                                $n_char = self::CHAR_LIST[$i - self::STANDART_SPACING];
                                break;
                            }
                        } while (!$find);
                        break;
                    } elseif ($i < self::STANDART_SPACING) {
                        $find = false;
                        do {
                            if (isset(self::CHAR_LIST[$i - self::STANDART_SPACING])) {
                                $n_char = self::CHAR_LIST[$i - self::STANDART_SPACING];
                                break;
                            } elseif (isset(self::CHAR_LIST[($i - self::STANDART_SPACING) + count(self::CHAR_LIST)])) {
                                $n_char = self::CHAR_LIST[($i - self::STANDART_SPACING) + count(self::CHAR_LIST)];
                                break;
                            }
                        } while (!$find);
                        break;
                    }
                }
            }
        }
        return $n_char;
    }

    public function t(){
        return count(self::CHAR_LIST);
    }
}