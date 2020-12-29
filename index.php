<?php
    require_once "App/Autoloader.php";
    __load_all_classes();
    session_start();
    Message::__init_messages();

    if (isset($_POST["nav-logout-button"]) and SessionManager::is_registered($_SESSION)){
        unset($_SESSION["data"]);

        if ($_SESSION["temp_user"] instanceof TempUser){
            $u = $_SESSION["temp_user"];
            $u->disconnect();
            unset($_SESSION["temp_user"]);
        }
        header("Location: login.php");
    }

    foreach (Message::$messages as $message){
        if ($message instanceof Message){
            if (ForbiddenMessage::contain_forbidden_word($message->getMessage())){
                $message->delete_message();
            }
        }
    }

    if (!SessionManager::is_registered($_SESSION)){
        header("Location: login.php");
    }
?>

<html lang="fr">
    <head>
        <title> Olympus </title>
        <link rel="icon" href="images/fav-icon.png">

        <!-- Head Meta -->
        <meta charset="UTF-8">
        <meta name="creator" content="Neptune">
        <meta name="Olympus est un site de Chat-Box ou tout les utilisateurs peuvent parler sans contraintes ni lois">
        <meta name="keywords" content="Olympus, Olympe, Blog, Chat-Box, Neptune, NeptuneDev">

        <!-- CSS Style -->
        <link href="templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="templates/css/nav-bar.css">
        <link rel="stylesheet" href="templates/css/index-style.css">

        <script language="JavaScript">
            window.addEventListener("onclose", function(){
                <?php
                    if ($_SESSION["temp_user"] instanceof TempUser){
                        $u = $_SESSION["temp_user"];

                        if (SqlManager::dataExist("SELECT * FROM `connected` WHERE name = '" . $u->getUsername() . "'", SqlManager::DATABASE_OLYMPUS)){
                            if (!SessionManager::is_registered($_SESSION)){
                                $u->disconnect();
                            }
                        }
                    }
                ?>
            })
        </script>
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
                    <img src="images/olympus-logo.png">
                </span>
                <br><br><br><br><br><br><hr>
            </div>
        </nav>

        <div class="connected">
            <div class="border-left"></div>
            <?php
                $t_pos = 25;

                foreach (SqlManager::getData("SELECT * FROM connected", SqlManager::DATABASE_OLYMPUS) as $key => $value){
                    echo "<p style='color: white; white-space: pre; position: absolute; left: 93%; top: $t_pos%;'> {$value['name']} </p>";
                    $t_pos += 4;
                }
            ?>
        </div>

        <div class="chat-box">
            <?php
                foreach (SqlManager::getData("SELECT * FROM messages ORDER BY `id`", SqlManager::DATABASE_OLYMPUS) as $key => $data){
                    $m = new Message($data["content"], $data["author"], $data["id"]);
                    echo $m->format_string();
                }
            ?>
        </div>

        <form class="chat-form" action="index.php" method="post" name="chat-form">
            <input type="text" name="chat-input" placeholder="Ecrivez ici..." autocomplete="off">
            <button type="submit"><img src="images/send-message.png" name="paper-plane"></button>
        </form>
    </body>
</html>

<?php

if ($_SESSION["data"] instanceof SessionManager){
    $session_manager = $_SESSION["data"];

    if (!empty($_POST["chat-input"])){
        try {
            SqlManager::writeData("INSERT INTO messages(
                    author, content
                ) VALUES (
                    '" . $session_manager->get_data("pseudo") . "', '" . $_POST["chat-input"] . "'
                )
            ", SqlManager::DATABASE_OLYMPUS);
            header("refresh: 0");
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}

?>