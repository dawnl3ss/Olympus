<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/Autoloader.php";
    __load_all_classes();
    session_start();
    $message = "";

    if (User::is_login($_SESSION))
        header("Location: ../../");

    if (isset($_POST["register-sub"])){
        if (!empty($_POST["pseudo"]) && !empty($_POST["email"]) && !empty($_POST["password"])){
            if (!SQLManager::data_exist("SELECT * FROM `users` WHERE email = '" . $_POST["email"] . "'", SQLManager::DATABASE_OLYMPUS)){
                SQLManager::write_data("INSERT INTO `users` (
                    pseudo, password, email
                ) VALUES (
                    '" . $_POST["pseudo"] ."', '" . $_POST["password"] . "', '" . $_POST["email"] . "'
                )", SQLManager::DATABASE_OLYMPUS);
                header("Location: login.php");
            } else $message = "Un compte est déjà enregistré à cette email.";
        } else $message = "Veuillez remplir tous les champs.";
    }
?>

<html lang="FRA">
    <head>
        <title> Olympus - Register </title>
        <meta charset="utf-8">
        <link rel="icon" href="../../image/fav-icon.png">

        <!-- CSS Style -->
        <link href="../../style/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../style/nav-bar.css">
        <link rel="stylesheet" href="../../style/register-style.css">
    </head>

    <body>
        <nav class="nav-bar">
            <div>
                <label>
                    <a href="../.."><button name="nav-home-button"> Acceuil </button></a>
                </label>
                <label>
                    <a href="login.php"><button name="nav-login-button"> Login </button></a>
                </label>
                <label>
                    <a href="register.php"><button name="nav-register-button"> Register </button></a>
                </label>
                <span>
                    <img src="../../image/olympus-logo.png" name="logo">
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
