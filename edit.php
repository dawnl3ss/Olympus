<?php
    require_once "App/Autoloader.php";
    __load_all_classes();
    session_start();
    $u = null;
    $post = $_POST;

    if (!SessionManager::is_registered($_SESSION)){
        header("Location: login.php");
    }

    if ($_SESSION["temp_user"] instanceof TempUser) {
        $u = $_SESSION["temp_user"];
    }

    if (isset($post["edit-sub"])){
        if (!empty($post["username"]) and !empty($post["password"]) and !empty($post["email"]) and !empty($post["id"])){
            if (($post["username"] === $u->getUsername()) and ($post["password"] === $u->getPassword()) and ($post["email"] === $u->getMail()) and ((int)$post["id"] === $u->getId())){} else {
                if ($post["username"] !== $u->getUsername()){
                    $u->update("pseudo", $post["username"])->send_instance_content("username", $post["username"]);
                }

                if ($post["password"] !== PassEncryption::decrypt_pass($u->getPassword())){
                    $u->update("password", PassEncryption::encrypt_pass($post["password"]))->send_instance_content("password", PassEncryption::encrypt_pass($post["password"]));
                }

                if ($post["email"] !== $u->getMail()){
                    $u->update("email", $post["email"])->send_instance_content("email", $post["email"]);
                }
                header("Location: profile.php");
            }
        }
    }
?>

<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title> Olympus - Edit Profile </title>
        <link rel="icon" href="images/fav-icon.png">

        <!-- CSS Style -->
        <link href="templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="templates/css/nav-bar.css">
        <link rel="stylesheet" href="templates/css/edit-style.css">
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

        <div class="div-profile-edit">
            <form class="edit-form" action="" method="post">
                <div class="div-profile-username">
                    <label>
                        <h3> Username : </h3>
                        <input type="text" value="<?php echo $u->getUsername(); ?>" name="username" autocomplete="off">
                    </label>
                </div>
                <div class="div-profile-password">
                    <label>
                        <h3> Password : </h3>
                        <input type="text" value="<?php echo PassEncryption::decrypt_pass($u->getPassword()); ?>" name="password" autocomplete="off">
                    </label>
                </div>
                <div class="div-profile-id">
                    <label>
                        <h3> User ID : </h3>
                        <input type="text" value="<?php echo $u->getId(); ?>" name="id" autocomplete="off">
                    </label>
                </div>
                <div class="div-profile-email">
                    <label>
                        <h3> Email : </h3>
                        <input type="text" value="<?php echo $u->getMail(); ?>" name="email" autocomplete="off">
                    </label>
                </div>
                <input type="submit" class="edit-submit" name="edit-sub">
            </form>
            <a href="profile.php">
                <img class="back-arrow-image" src="images/back-arrow.png">
            </a>
        </div>
    </body>
</html>
