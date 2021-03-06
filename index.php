<?php
require 'bdd.php';
if (isset($_POST['login'])) {
    header('Location: login.php');
    exit;
}
if (isset($_POST['register'])) {
    header('Location: register.php');
    exit;
}
?>

<!doctype html>
<html>

    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <title>CTFD_Like</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
        <link rel="stylesheet" href="assets/css/Card-Group1-Shadow.css">
        <link rel="stylesheet" href="assets/css/Dark-NavBar-1.css">
        <link rel="stylesheet" href="assets/css/Dark-NavBar-2.css">
        <link rel="stylesheet" href="assets/css/Dark-NavBar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="assets/css/Search-Input-responsive.css">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>

    <body>
        <nav class="navbar navbar-light navbar-expand-md sticky-top border rounded float-none navigation-clean-button"
            style="height: 80px;background-color: #37434d;color: #ffffff;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"
                    style="filter: blur(0px);width: 182px;margin: -18px;">CTFD_Like</a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="register.php">
                    <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i>
                      Register
                </a>
                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;width: 80;margin: 0;"
                    href="login.php">
                    <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i> 
                    Login
                </a>
            </div>
        </nav>
    </body>

</html>
