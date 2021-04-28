<?php

require_once "App/Autoloader.php";
__load_all_classes();

$password = "azerty123";

echo "Mot de Passe : " . $password . "<br>";
echo "Crypté : " . $hash = PassEncryption::encrypt_pass($password) . "<br>";
echo "Décrypté : " . PassEncryption::decrypt_pass($hash) . "<br>";


