<?php
    require_once "App/Autoloader.php";
    __load_all_classes();
    session_start();

    if (!SessionManager::is_registered($_SESSION)){
        header("Location: login.php");
    }
?>


<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title> Olympus - Profile </title>
        <link rel="icon" href="images/fav-icon.png">

        <!-- CSS Style -->
        <link href="templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="templates/css/nav-bar.css">
        <link rel="stylesheet" href="templates/css/profile-style.css">
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
        </nav>

        <div class="div-profile-details">
            <?php
                $u = null;

                if ($_SESSION["temp_user"] instanceof TempUser){
                    $u = $_SESSION["temp_user"];
                }
            ?>
            <div class="div-profile-username">
                <h3> Username : </h3>
                <h5> <?php echo $u->getUsername() ?> </h5>
            </div>
            <div class="div-profile-password">
                <h3> Password : </h3>
                <h5> <?php echo PassEncryption::decrypt_pass($u->getPassword()) ?> </h5>
            </div>
            <div class="div-profile-id">
                <h3> User ID : </h3>
                <h5> <?php echo $u->getId() ?> </h5>
            </div>
            <div class="div-profile-email">
                <h3> Email : </h3>
                <h5> <?php echo $u->getMail() ?> </h5>
            </div>
            <div class="edit-profile">
                <br><br><br>
                <a href="edit.php">
                    <button class="edit-button" type="submit" name="edit-button">    Editer <img class="edit-img" src="images/edit.png"></button>
                </a>
            </div>
            <a href="../Olympus">
                <img class="back-arrow-image" src="images/back-arrow.png">
            </a>
        </div>
    </body>
</html>
