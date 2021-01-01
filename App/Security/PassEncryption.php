<?php

class PassEncryption {

    /**
     * @param $plaintext
     *
     * @param $password
     *
     * @return string
     */
    public static function encrypt_pass($plaintext, $password) {
        $method = "AES-256-CBC";
        $hack = "SxLow";
        $key = hash('sha256', $password, true);
        $iv = openssl_random_pseudo_bytes(16);
        $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
        $hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);
        return $iv . $hash . $ciphertext;
    }

    /**
     * @param $ivHashCiphertext
     *
     * @param $password
     *
     * @return false|string|null
     */
    public static function decrypt_pass($ivHashCiphertext, $password) {
        $method = "AES-256-CBC";
        $iv = substr($ivHashCiphertext, 0, 16);
        $hash = substr($ivHashCiphertext, 16, 32);
        $ciphertext = substr($ivHashCiphertext, 48);
        $key = hash('sha256', $password, true);
        if (!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash)) return null;
        return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
    }
}