<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/Autoloader.php";
    __load_all_classes();
    session_start();
    Message::__init_messages();

    if (!User::is_login($_SESSION))
        header("Location: page/auth/login.php");
?>

<html lang="fr">
    <head>
        <title> Olympus </title>
        <link rel="icon" href="image/fav-icon.png">

        <!-- Head Meta -->
        <meta charset="UTF-8">
        <meta name="creator" content="Neptune">
        <meta name="Olympus est un site de Chat-Box ou tout les utilisateurs peuvent parler sans contraintes ni lois">
        <meta name="keywords" content="Olympus, Olympe, Blog, Chat-Box, Neptune, NeptuneDev">

        <!-- CSS Style -->
        <link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style/nav-bar.css">
        <link rel="stylesheet" href="style/index-style.css">
    </head>

    <body>
        <nav class="nav-bar">
            <div>
                <label>
                    <a href=""><button name="nav-home-button"> Acceuil </button></a>
                </label>
                <?php if (!User::is_login($_SESSION)) : ?>
                    <label>
                        <a href="page/auth/login.php"><button name="nav-login-button"> Login </button></a>
                    </label>
                <?php endif; ?>
                <?php if (!User::is_login($_SESSION)) : ?>
                    <label>
                        <a href="page/register.php"><button name="nav-register-button"> Register </button></a>
                    </label>
                <?php endif; ?>
                <?php if (User::is_login($_SESSION)) : ?>
                    <label>
                        <a href="page/auth/logout.php"><button name="nav-register-button"> Logout </button></a>
                    </label>
                <?php endif; ?>
                <?php if (User::is_login($_SESSION)) : ?>
                    <label>
                        <a href="page/profile.php"><button name="nav-profile-button"> Profile </button></a>
                    </label>
                <?php endif; ?>
                <?php if (User::is_login($_SESSION)) : ?>
                    <label>
                        <a href="page/dm.php"><img src="image/dm-letter.png" name="dm"></a>
                    </label>
                <?php endif; ?>
                <span>
                    <img src="image/olympus-logo.png" name="logo">
                </span>
                <br><br><br><br><br><hr>
            </div>
        </nav>

        <div class="connected">
            <div class="border-left">
                <h5 class="border-left-title"> Connected </h5>
            </div>
            <?php
                $t_pos = 25;
    
                foreach (SQLManager::get_data("SELECT * FROM connected", SQLManager::DATABASE_OLYMPUS) as $key => $value){
                    echo "<p style='color: white; white-space: pre; position: absolute; left: 93%; top: $t_pos%;'> {$value['name']} </p>";
                    $t_pos += 4;
                }
            ?>
        </div>

        <div class="chat-box">
            <br>
            <?php
                foreach (MessageHandler::$messages as $message){
                    if ($message instanceof Message){
                        if (contain_forbidden_word($message->get_message())){
                            $message->delete_message();
                            continue;
                        }
                        echo $message->format_string();
                    }
                }
            ?>
            <br>
        </div>

        <div class="chat-back"></div>
        <form class="chat-form" action="" method="post" name="chat-form">
            <input type="text" name="chat-input" placeholder="Ecrivez ici..." autocomplete="off">
            <button type="submit"><img src="image/send-message.png" name="paper-plane"></button>
        </form>
    </body>
</html>

<?php
    if ($_SESSION["user"] instanceof User){
        $user = $_SESSION["user"];

        if (!empty($_POST["chat-input"])){
            SQLManager::write_data("INSERT INTO messages(
                    author, content
                ) VALUES (
                    '" . $user->get_username() . "', '" . htmlspecialchars($_POST["chat-input"]) . "'
                )
            ", SQLManager::DATABASE_OLYMPUS);
            header("refresh: 0");
        }
    }
?>
