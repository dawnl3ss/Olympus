<?php

require_once "App/Autoloader.php";
__load_all_classes();
session_start();
$message = "";
$post = $_POST;

if (SessionManager::is_registered($_SESSION)){
    header("Location: ../Olympus");
}

if (isset($post["register-sub"])){
    if (!empty($post["pseudo"]) and !empty($post["email"]) and !empty($post["password"])){
        if (!SqlManager::dataExist("SELECT * FROM users WHERE email = '" . $post["email"] . "'", SqlManager::DATABASE_OLYMPUS)){
            SqlManager::writeData("INSERT INTO users(
                pseudo, password, email
            ) VALUES (
                '" . $post["pseudo"] . "', '" . $post["password"] . "', '" . $post["email"] . "'
            )", SqlManager::DATABASE_OLYMPUS);
            header("Location: login.php");
        } else {
           $message = "Un compte est déjà enregistré à cette email.";
        }
    } else {
        $message = "Veuillez remplir tout les champs.";
    }
}

?>

<html lang="FRA">
    <head>
        <title> Olympus - Register </title>
        <meta charset="utf-8">
        <link rel="icon" href="images/fav-icon.png">

        <!-- CSS Style -->
        <link href="templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="templates/css/nav-bar.css">
        <link rel="stylesheet" href="templates/css/register-style.css">
    </head>

    <body>
        <nav class="nav-bar">
            <div>
                <label>
                    <a href="/Olympus"><button name="nav-home-button"> Acceuil </button></a>
                </label>
                <label>
                    <a href="login.php"><button name="nav-login-button"> Login </button></a>
                </label>
                <label>
                    <a href="register.php"><button name="nav-register-button"> Register </button></a>
                </label>
                <span>
                    <img src="images/olympus-logo.png">
                 </span>
                <br><br><br><br><br><br><hr>
            </div>
        </nav>

        <form class="box" action="register.php" method="post" name="register-form">
            <h1> Register </h1>
            <label>
                <input type="text" name="pseudo" placeholder="Pseudo" autocomplete="off">
            </label>
            <label>
                <input type="text" name="email" placeholder="Email" autocomplete="off">
            </label>
            <label>
                <input type="password" name="password" placeholder="Password">
            </label>
            <input type="submit" name="register-sub" value="- Register -">
            <div>
                <p> <?php echo $message ?> </p>
            </div>
        </form>
    </body>
</html>