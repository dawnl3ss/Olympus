<?php

require_once "App/Security/ARS_SHELL_CRYPT/cryptage/Encryption.php";

class PassEncryption {

    /**
     * @param string $password
     *
     * @return string
     */
    public static function encrypt_pass(string $password){
        return (new Encryption($password, Encryption::STANDARD_SPACING_SEC_1))->str_encrypt();
    }

    /**
     * @param string $hash
     *
     * @return string
     */
    public static function decrypt_pass(string $hash){
        return (new Encryption("", Encryption::STANDARD_SPACING_SEC_1, [
            "encrypted" => $hash,
            "decrypted" => ""
        ]))->str_decrypt();
    }
}