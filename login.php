<?php

require_once "App/Autoloader.php";
__load_all_classes();
session_start();
$message = "";
$post = $_POST;

if (SessionManager::is_registered($_SESSION)){
    header("Location: ../Olympus");
}

if (isset($post["login-sub"])){
    if (!empty($post["email"]) and !empty($post["password"])){
        if (SqlManager::dataExist("SELECT * FROM users WHERE email = '" . $post["email"] . "' AND password = '" . md5($post["password"]) . "'", SqlManager::DATABASE_OLYMPUS)){
            $data = SqlManager::getData("SELECT * FROM users WHERE email = '" . $post["email"] . "' AND password = '" . md5($post["password"]) . "'", SqlManager::DATABASE_OLYMPUS);
            $session = new SessionManager([
                "id" => $data[0]["id"],
                "pseudo" => $data[0]["pseudo"],
                "email" => $data[0]["email"],
                "password" => $data[0]["password"]
            ], false);
            $u = new TempUser([
                "username" => $data[0]["pseudo"],
                "password" => $data[0]["password"],
                "id" => $data[0]["id"]
            ]);
            $u->connect();
            $_SESSION["data"] = $session;
            $_SESSION["temp_user"] = $u;
            header("Location: index.php");
        } else {
            $message = "Mauvais identifiant(s)";
        }
    } else {
        $message = "Veuillez remplir tout les champs.";
    }
}
?>

<html lang="FRA">
    <head>
        <title> Olympus - Login </title>
        <meta charset="utf-8">
        <link rel="icon" href="images/fav-icon.png">

        <!-- CSS Style -->
        <link href="templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="templates/css/nav-bar.css">
        <link rel="stylesheet" href="templates/css/login-style.css">
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

        <form class="box" action="login.php" method="post" name="login-form">
            <h1> Login </h1>
            <label>
                <input type="text" name="email" placeholder="Email" autocomplete="off">
            </label>
            <label>
                <input type="password" name="password" placeholder="Password" autocomplete="off">
            </label>
            <input type="submit" name="login-sub" value="- Login -">
            <div>
                <p> <?php echo $message ?> </p>
            </div>
        </form>
    </body>
</html>