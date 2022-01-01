<?php

/**
 * @param string $password
 *
 * @return string
 */
function encrypt_password(string $password) : string {
    return password_hash($password, PASSWORD_BCRYPT, ["cost" => 13]);
}