<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/Olympus-rewrite/app/Autoloader.php";
    __load_all_classes();
    session_start();
    $message = "";

    if (User::is_login($_SESSION))
        header("Location: ../../");

    if (isset($_POST["login-sub"])){
        if (!empty($_POST["email"]) && !empty($_POST["password"])){
            $stmt = "SELECT * FROM `users` WHERE email = '" . $_POST["email"] . "' AND password = '" . $_POST["password"] . "';";

            if (SQLManager::data_exist($stmt, SQLManager::DATABASE_OLYMPUS)){
                $data = SQLManager::get_data($stmt, SQLManager::DATABASE_OLYMPUS);
                $_SESSION["user"] = $user = new User([
                    "id" => (int)$data[0]["id"],
                    "username" => $data[0]["pseudo"],
                    "email" => $data[0]["email"],
                    "admin" => (int)$data[0]["id"] === 1
                ]);
                $user->connect();
                header("Location: ../../");
            } else $message = "Les identifiants sont invalides.";
        } else $message = "Veuillez remplir tous les champs.";
    }
?>

<html lang="FRA">
    <head>
        <title> Olympus - Login </title>
        <meta charset="utf-8">
        <link rel="icon" href="../../image/fav-icon.png">

        <!-- CSS Style -->
        <link href="../../style/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../style/nav-bar.css">
        <link rel="stylesheet" href="../../style/login-style.css">
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
