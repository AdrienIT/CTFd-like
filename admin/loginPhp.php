<?php
require '../bdd.php';

session_start();

if (isset($_SESSION["admin_id"])) {
    header("Location: index.php");
}

// $username = "admin"; //Remplacer par variable env dans .env
$xpassword = "root"; //Remplacer par variable env dans .env

$id = (int) $_SESSION["admin_id"];

$query_get_id = $pdo->prepare("SELECT * FROM admin WHERE admin_id = :id ");
$query_get_id->bindParam(":id", $id);
$query_get_id->execute();
$admin = $query_get_id->fetch();

if (isset($_POST["connexion"])) {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);



    $querry_is_admin = $pdo->prepare('SELECT username from admin where username = :username');
    $querry_is_admin->bindParam(':username', $username);
    $querry_is_admin->execute();

    if ($querry_is_admin->rowCount() == 0) {
        header('Location: ../login.php');
        exit;
    }

    $query_get_hash = $pdo->prepare("SELECT password FROM admin WHERE username = :username");
    $query_get_hash->bindParam(':username', $username);
    $query_get_hash->execute();
    $hash = $query_get_hash->fetch();

    if (password_verify($password, implode($hash))) {
        $_SESSION["admin_id"] = (int) $admin["admin_id"];
        header('Location: ./index.php');
        exit;
    } elseif (empty($hash)) {
        echo "<script type='text/javascript'>alert('Le nom d utilisateur ou le mot de passe ne correspondent pas.');</script>";
    } elseif (!password_verify($password, implode($hash))) {
        $passwd_hash = password_hash($xpassword, PASSWORD_BCRYPT);
        $querry_change_info = $pdo->prepare("UPDATE admin SET password = :password WHERE username = :username");
        $querry_change_info->bindparam(":password", $passwd_hash);
        $querry_change_info->bindparam(":username", $username);
        $querry_change_info->execute();
        header("Refresh:0");
    }
}



?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Admin Log in</title>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
        <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
        <link rel="stylesheet" href="../assets/css/Form-Select---Full-Date---Month-Day-Year.css">
        <link rel="stylesheet" href="../assets/css/Google-Style-Login.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="../assets/css/Login-Box-En.css">
        <link rel="stylesheet" href="../assets/css/Registration-Form-with-Photo.css">
        <link rel="stylesheet" href="../assets/css/styles.css">
        <link rel="stylesheet" href="../assets/css/Search-Input-responsive.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar-1.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar-2.css">
        <link rel="stylesheet" href="../assets/css/Dark-NavBar.css">


    </head>

    <body>
        <nav class="navbar navbar-light navbar-expand-md sticky-top border rounded float-none navigation-clean-button"
            style="height: 80px;background-color: #37434d;color: #ffffff;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php"
                    style="filter: blur(0px);width: 182px;margin: -18px;">CTFD_Like</a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;width: 80;margin: 0;"
                    href="../register.php">
                    <i class="fa fa-sign-in" style="height: -5px;width: 23px;padding: 4px;"></i>Register
                </a>
            </div>
        </nav>
        <div class="register-photo">
            <div class="form-container"></div>
        </div>
        <div class="register-photo">
            <div class="form-container">
                <form method="post">
                    <h2 class="text-center"><strong>Connexion</strong></h2>
                    <div class="form-group"><input class="form-control" type="text" name="username"
                            placeholder="username"></div>
                    <div class="form-group"><input class="form-control" type="password" name="password"
                            placeholder="Password"></div>
                    <div class="form-group"><button class="btn btn-primary btn-block" type="submit"
                            name="connexion">Connexion au compte</button></div>
                </form>
            </div>
        </div>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/bs-init.js"></script>
    </body>

</html>
