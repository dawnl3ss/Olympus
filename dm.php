<?php

    require_once "App/Autoloader.php";
    __load_all_classes();
    session_start();

    if ($_SESSION["temp_user"] instanceof TempUser) MessageHandler::__init_private_messages($user = $_SESSION["temp_user"]);

?>

<html>
    <head>
        <title> Olympus - Private Messages </title>
        <meta charset="utf-8">
        <link rel="icon" href="images/fav-icon.png">

        <!-- CSS Style -->
        <link href="templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="templates/css/nav-bar.css">
        <link rel="stylesheet" href="templates/css/dm-style.css">
    </head>

    <body>
        <nav class="nav-bar">
            <div>
                <label>
                    <a href="/Olympus"><button name="nav-home-button"> Acceuil </button></a>
                </label>
                <?php if (!SessionManager::is_registered($_SESSION)) : ?>
                    <label>
                        <a href="login.php"><button name="nav-login-button"> Login </button></a>
                    </label>
                <?php endif; ?>
                <?php if (!SessionManager::is_registered($_SESSION)) : ?>
                    <label>
                        <a href="register.php"><button name="nav-register-button"> Register </button></a>
                    </label>
                <?php endif; ?>
                <?php if (SessionManager::is_registered($_SESSION)) : ?>
                    <form action="../Olympus/" method="post">
                        <input type="submit" name="nav-logout-button" value="Logout">
                    </form>
                <?php endif; ?>
                <?php if (SessionManager::is_registered($_SESSION)) : ?>
                    <label>
                        <a href="profile.php"><button name="nav-profile-button"> Profile </button></a>
                    </label>
                <?php endif; ?>
                <span>
                    <img src="images/olympus-logo.png" name="logo">
                </span>
                <br><br><br><br><br><br><hr>
            </div>
            <?php
                $current_recipient = null;

                foreach ($user->getConversations() as $message){
                    if ($message->getAuthor() === $user->getUsername()){
                        echo $message->getRecipient() . "<br>";
                    } else echo $message->getAuthor() . "<br>";
                    /*if (is_null($current_recipient)) $current_recipient = $message->getRecipient();

                    if ($current_recipient === $message->getRecipient()){
                        echo $message->format_string();
                    } else {
                        echo "<hr>";
                        echo $message->format_string();
                        $current_recipient = $message->getRecipient();
                    }*/
                }
            ?>
        </nav>
    </body>
</html>