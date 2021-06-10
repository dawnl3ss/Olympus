<?php

    require_once "App/Autoloader.php";
    __load_all_classes();
    session_start();

    if ($_SESSION["temp_user"] instanceof TempUser) {
        MessageHandler::__init_private_messages($user = $_SESSION["temp_user"]);
    }

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
                    <a href="/Olympus"><button name="nav-home-button"> Accueil </button></a>
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
                <?php if (SessionManager::is_registered($_SESSION)) : ?>
                    <label>
                        <a href="dm.php" onclick=""><img src="images/dm-letter.png" name="dm"></a>
                    </label>
                <?php endif; ?>
                <span>
                    <img src="images/olympus-logo.png" name="logo">
                </span>
                <br><br><br><br><br><br><hr>
            </div>
        </nav>

        <div class="main-menu">
            <form action="dm.php" method="get">
                <div class="selection-box">
                    <?php
                        $current_recipients = [];

                        foreach ($user->getConversations() as $message){
                            if (!in_array($message->getRecipient(), $current_recipients) and !in_array($message->getAuthor(), $current_recipients)){
                                if ($message->getAuthor() === $user->getUsername()){
                                    echo "<button type='submit' name='{$message->getRecipient()}'> {$message->getRecipient()} </button>";
                                    array_push($current_recipients, $message->getRecipient());
                                } else {
                                    echo "<button type='submit' name='{$message->getAuthor()}> {$message->getAuthor()} </button>";
                                    array_push($current_recipients, $message->getAuthor());
                                }
                            } else continue;
                        }
                    ?>
                </div>
            </form>

            <div class="message-menu">
                <p>
                    <?php
                        foreach ($_GET as $key => $value){
                            foreach ($user->getConversations() as $message){
                                if ($message->getAuthor() === $key or $message->getRecipient() === $key){
                                    echo $message->format_string();
                                }
                            }
                        }
                    ?>
                </p>
            </div>
        </div>
    </body>
</html>