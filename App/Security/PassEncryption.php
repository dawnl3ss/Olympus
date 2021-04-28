<?php

require_once "App/Security/ARS_SHELL_CRYPT/ARS_SHELL_CRYPT.php";

class PassEncryption {

    /**
     * @param string $password
     *
     * @return string
     */
    public static function encrypt_pass(string $password){
        $encrypt = "";

        for ($i = 0; $i < strlen($password); $i++){
            $encrypt .= (new ARS_SHELL_CRYPT())->char_to_achar($password[$i], ARS_SHELL_CRYPT::METHOD_CRYPT);
        }
        return $encrypt . "/-(_@25az" . strrev($encrypt) . "(_*%-$*=";
    }

    /**
     * @param string $hash
     *
     * @return string
     */
    public static function decrypt_pass(string $hash){
        $hash = explode("/-(_@25az", $hash)[0];
        $decrypt = "";

        for ($i = 0; $i < strlen($hash); $i++){
            $decrypt .= (new ARS_SHELL_CRYPT())->char_to_achar($hash[$i], ARS_SHELL_CRYPT::METHOD_DECRYPT);
        }
        return $decrypt;
    }
}