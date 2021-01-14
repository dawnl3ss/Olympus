<?php
    require_once "App/Autoloader.php";
    __load_all_classes();
    session_start();
    $session = $_SESSION;
    $post = $_POST;
    $response_text = "";

    if (!SessionManager::is_registered($session)){
        header("Location: login.php");
    }

    if ($session["temp_user"] instanceof TempUser){
        if (!$session["temp_user"]->isAdmin()){
            header("Location: index.php");
        }
    }

    if (isset($post["submit-button"])){
        if (!empty($post["sql-input"])){
            $response_text = AdminTools::apply_sql_command($post["sql-input"], SqlManager::determinate_sql_request_type($post["sql-input"]));
        }

        if (!empty($post["shell-input"])){
            $response_text = AdminTools::apply_shell_command($post["shell-input"]);
        }
    }
?>

<html>
    <head>
        <title> Olympus - Admin Panel </title>
        <meta charset="utf-8">
        <link rel="icon" href="images/fav-icon.png">

        <!-- CSS Style -->
        <link href="templates/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="templates/css/nav-bar.css">
        <link rel="stylesheet" href="templates/css/admin-style.css">
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

        <div class="admin-form">
            <form action="" method="post" name="admin-form-base">
                <div class="div-sql">
                    <h3 class="sql-title"> SQL Input </h3>
                    <label>
                        <input type="text" name="sql-input" placeholder="SELECT * FROM ..." autocomplete="off">
                    </label>
                </div>
                <div class="shell-div">
                    <h3 class="shell-title"> Shell Entry </h3>
                    <label>
                        <input type="text" name="shell-input" placeholder="#~" autocomplete="off">
                    </label>
                </div>
                <button name="submit-button"> Envoyer </button>
            </form>
        </div>
        <div class="response-space">
            <div class="response-header">
                <h3> Response Panel </h3><hr>
                <div class="response-text">
                    <p style="white-space: pre"> <?php echo $response_text ?> </p>
                </div>
            </div>
        </div>
    </body>
</html>